window.onload = function () {
    fetch("checkSession.php")
        .then((response) => response.json())
        .then((jsonData) => {
            var logged = jsonData.logged; // Access the logged property
            if (logged) {
                document.getElementById("register").style.display = "none";
                document.getElementById("log-in").style.display = "none";
                document.getElementById("content").style.display = "block";
                AsyncGetContent();
            }
            // else {
            //     document.getElementById("register").style.display = "none";
            //     document.getElementById("log-in").style.display = "block";
            //     document.getElementById("content").style.display = "none";
            // }
        });
};

function AsyncRegister() {
    var login = document.getElementById("reg_login").value;
    var password = document.getElementById("reg_password").value;
    var info = document.getElementById("reg_info").value;

    fetch("async.php", {
        method: "POST",
        body: JSON.stringify({
            action: "register",
            login: login,
            password: password,
            info: info,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then((message) => {
            // Обробляємо різні повідомлення
            if (message === "Registered successfully") {
                document.getElementById("reg_login").value = "";
                document.getElementById("reg_password").value = "";
                document.getElementById("reg_info").value = "";

                document.getElementById("register").style.display = "none";
                document.getElementById("log-in").style.display = "none";
                document.getElementById("content").style.display = "block";
                AsyncGetContent();
            } else {
                var table = document.getElementById("table-register");
                var tr = document.createElement("tr");
                tr.id = "reg-error";
                var emptytd = document.createElement("td");
                tr.appendChild(emptytd);
                var td = document.createElement("td");
                if (message === "Missing login or password") {
                    td.innerHTML = "Ви не ввели логін або пароль!";
                    tr.appendChild(td);
                    table.appendChild(tr);
                } else if (message === "Login is already taken") {
                    td.innerHTML = "Такий логін вже зайнятий";
                    tr.appendChild(td);
                    table.appendChild(tr);
                } else if (
                    message === "Password is to short, 8 characters minimum"
                ) {
                    td.innerHTML =
                        "Пароль занадто короткий, 8 символів мінімум";
                    tr.appendChild(td);
                    table.appendChild(tr);
                } else {
                    td.innerHTML = message;
                    tr.appendChild(td);
                    table.appendChild(tr);
                }
            }
        })
        .catch((error) => {
            console.error(
                "There has been a problem with your fetch operation:",
                error
            );
            alert("An error occurred during registration.");
        });
}

function AsyncLogin() {
    var login = document.getElementById("log-in_login").value;
    var password = document.getElementById("log-in_password").value;

    fetch("async.php", {
        method: "POST",
        body: JSON.stringify({
            action: "log-in",
            login: login,
            password: password,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then((message) => {
            // Обробляємо різні повідомлення
            if (message === "Logged succesfully") {
                document.getElementById("log-in_login").value = "";
                document.getElementById("log-in_password").value = "";

                document.getElementById("register").style.display = "none";
                document.getElementById("log-in").style.display = "none";
                document.getElementById("content").style.display = "block";
                AsyncGetContent();
            } else {
                var table = document.getElementById("table-log-in");
                var tr = document.createElement("tr");
                tr.id = "log-error";
                var emptytd = document.createElement("td");
                tr.appendChild(emptytd);
                var td = document.createElement("td");
                if (message === "Missing login or password") {
                    td.innerHTML = "Ви не ввели логін або пароль!";
                    tr.appendChild(td);
                    table.appendChild(tr);
                } else if (message === "Wrong login or password") {
                    td.innerHTML = "Неправильний логін або пароль";
                    tr.appendChild(td);
                    table.appendChild(tr);
                } else {
                    td.innerHTML = message;
                    tr.appendChild(td);
                    table.appendChild(tr);
                }
            }
        })
        .catch((error) => {
            console.error(
                "There has been a problem with your fetch operation:",
                error
            );
            alert("An error occurred during registration.");
        });
}

function AsyncGetContent() {
    var t = document.getElementById("table-content");
    if (t != null) {
        t.remove();
    }

    fetch("async.php", {
        method: "POST",
        body: JSON.stringify({
            action: "getContent",
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((jsonData) => {
            if (jsonData.length > 0) {
                var parent = document.getElementById("content");

                var table = document.createElement("table");
                table.id = "table-content";

                var trHeaders = document.createElement("tr");
                Object.keys(jsonData[0]).forEach((key) => {
                    var thHeader = document.createElement("th");
                    thHeader.innerHTML = key;
                    trHeaders.appendChild(thHeader);
                });

                var thEdit = document.createElement("th");
                var thDelete = document.createElement("th");

                thEdit.innerHTML = "edit";
                thDelete.innerHTML = "delete";

                trHeaders.appendChild(thDelete);
                trHeaders.appendChild(thEdit);

                table.appendChild(trHeaders);

                jsonData.forEach((object) => {
                    var id = object["id"];
                    var trItem = document.createElement("tr");
                    for (const key in object) {
                        if (Object.hasOwnProperty.call(object, key)) {
                            const value = object[key];

                            var tdItem = document.createElement("td");

                            if (key == "info") {
                                var textItem =
                                    document.createElement("textarea");
                                textItem.id = key + "_" + id;
                                textItem.innerHTML = value;
                                tdItem.appendChild(textItem);
                            } else {
                                var inputItem = document.createElement("input");

                                inputItem.id = key + "_" + id;
                                inputItem.type = "text";
                                inputItem.value = value;

                                if (key == "id") {
                                    inputItem.readOnly = true;
                                }

                                tdItem.appendChild(inputItem);
                            }
                        }
                        trItem.appendChild(tdItem);
                    }
                    var tdEdit = document.createElement("td");
                    var tdDelete = document.createElement("td");

                    var btnEdit = document.createElement("button");
                    var btnDelete = document.createElement("button");

                    btnEdit.innerHTML = "edit";
                    btnDelete.innerHTML = "delete";

                    btnEdit.id = "edit_" + id;
                    btnDelete.id = "delete_" + id;

                    btnEdit.onclick = function () {
                        var id = this.id;
                        id = id.match(/\d+/g)[0];

                        var login = document.getElementById(
                            "login_" + id
                        ).value;
                        var password = document.getElementById(
                            "password_" + id
                        ).value;
                        var info = document.getElementById("info_" + id).value;

                        AsyncEdit(id, login, password, info);
                    };

                    btnDelete.onclick = function () {
                        var id = this.id;
                        id = id.match(/\d+/g)[0];
                        AsyncDelete(id);
                    };

                    tdEdit.appendChild(btnEdit);
                    tdDelete.appendChild(btnDelete);

                    trItem.appendChild(tdEdit);
                    trItem.appendChild(tdDelete);
                    table.appendChild(trItem);
                });

                parent.appendChild(table);
            }
        })
        .catch((error) => {
            console.error(
                "There has been a problem with your fetch operation:",
                error
            );
            alert("An error occurred during registration.");
        });
}

function AsyncDelete(id) {
    fetch("async.php", {
        method: "POST",
        body: JSON.stringify({
            action: "delete-id",
            id: id,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then(() => {
            AsyncGetContent();
        })

        .catch((error) => {
            console.error(
                "There has been a problem with your fetch operation:",
                error
            );
            alert("An error occurred during registration.");
        });
}

function AsyncEdit(id, login, password, info) {
    fetch("async.php", {
        method: "POST",
        body: JSON.stringify({
            action: "edit-id",
            id: id,
            login: login,
            password: password,
            info: info,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then(() => {
            AsyncGetContent();
        })
        .catch((error) => {
            console.error(
                "There has been a problem with your fetch operation:",
                error
            );
            alert("An error occurred during registration.");
        });
}

function AsyncLogout() {
    fetch("async.php", {
        method: "POST",
        body: JSON.stringify({
            action: "log-out",
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .catch((error) => {
            console.error(
                "There has been a problem with your fetch operation:",
                error
            );
            alert("An error occurred during registration.");
        });
}

document.body.addEventListener("click", (event) => {
    target = event.target.id;
    if (target === "show_log-in") {
        document.getElementById("register").style.display = "none";
        document.getElementById("log-in").style.display = "block";
    } else if (target === "show_register") {
        document.getElementById("register").style.display = "block";
        document.getElementById("log-in").style.display = "none";
    } else if (target === "reg_create") {
        var reg_error = document.getElementById("reg-error");
        if (reg_error != null) {
            reg_error.remove();
        }
        AsyncRegister();
    } else if (target === "btn-log-in") {
        var log_error = document.getElementById("log-error");
        if (log_error != null) {
            log_error.remove();
        }
        AsyncLogin();
    } else if (target === "update-button") {
        AsyncGetContent();
    } else if (target === "log-out") {
        document.getElementById("content").style.display = "none";
        document.getElementById("log-in").style.display = "block";
        AsyncLogout();
    }
});
