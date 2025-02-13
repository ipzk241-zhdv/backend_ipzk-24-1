import { variablesSetting } from "./settings";

window.onload = function () {
    AsyncGetContent();
};

function Async(action, values) {
    var requestBody = {
        action: action,
    };

    for (var key in values) {
        if (values.hasOwnProperty(key)) {
            requestBody[key] = values[key];
        }
    }

    fetch("async.php", {
        method: "POST",
        body: JSON.stringify(requestBody),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(() => {
            AsyncGetContent();
        })
        .catch((error) => {
            console.error(
                "There has been a problem with your fetch operation:",
                error
            );
            alert("An error occurred fetch operation.");
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
            var table = document.createElement("table");
            table.id = "table-content";

            var trHeaders = document.createElement("tr");
            Object.keys(variablesSetting).forEach((key) => {
                var thHeader = document.createElement("th");
                thHeader.id = "th_" + key;
                thHeader.innerHTML = key;
                trHeaders.appendChild(thHeader);
            });

            table.appendChild(trHeaders);
            if (Array.isArray(jsonData) && jsonData.length > 0) {
                jsonData.forEach(function (item) {
                    var trItem = document.createElement("tr");

                    Object.keys(item).forEach(function (key) {
                        if (variablesSetting[key]) {
                            var td = document.createElement("td");
                            var input = document.createElement("input");
                            Object.keys(variablesSetting[key]).forEach(
                                function (settingKey) {
                                    if (settingKey === "readonly") {
                                        if (variablesSetting[key][settingKey]) {
                                            input.setAttribute(
                                                "readonly",
                                                "readonly"
                                            );
                                        }
                                    } else if (settingKey === "id") {
                                        input[settingKey] =
                                            variablesSetting[key][settingKey] +
                                            item[settingKey];
                                    } else {
                                        input[settingKey] =
                                            variablesSetting[key][settingKey];
                                    }
                                }
                            );
                            if (key == "isEdited") {
                                input.value = item[key]
                                    ? "відредактований"
                                    : "";
                            } else {
                                input.value = item[key];
                            }
                            td.appendChild(input);
                            trItem.appendChild(td);
                        }
                    });
                    ItemControlButtons(trItem, item["id"]);
                    table.appendChild(trItem);
                });
            }
            CreateNote(table);
            document.getElementById("content").appendChild(table);
        })
        .catch((error) => {
            console.error(
                "There has been a problem with your fetch operation:",
                error
            );
            alert("An error occurred during registration.");
        });
}

function ItemControlButtons(tr, id) {
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

        var caption = document.getElementById("caption_" + id).value;
        var note = document.getElementById("note_" + id).value;
        var city = document.getElementById("city_" + id).value;
        var isEdited = true;

        var editedDate = new Date(Date.now());
        editedDate.toISOString().split("T")[0];

        Async("edit-id", {
            id: id,
            caption: caption,
            note: note,
            city: city,
            editedDate: editedDate,
            isEdited: isEdited,
        });
    };

    btnDelete.onclick = function () {
        var id = this.id;
        id = id.match(/\d+/g)[0];
        Async("delete-id", { id: id });
    };

    tdEdit.appendChild(btnEdit);
    tdDelete.appendChild(btnDelete);

    tr.appendChild(tdEdit);
    tr.appendChild(tdDelete);
}

function CreateNote(table) {
    var trItem = document.createElement("tr");
    Object.keys(variablesSetting).forEach(function (key) {
        if (variablesSetting[key]) {
            var td = document.createElement("td");
            var input = document.createElement("input");
            Object.keys(variablesSetting[key]).forEach(function (settingKey) {
                var notUsedForCreating = [
                    "created",
                    "isEdited",
                    "editedDate",
                    "id",
                ];

                if (!notUsedForCreating.includes(key)) {
                    input.id = key + "_create";
                    td.appendChild(input);
                }
            });
            if (key == "edit") {
                var btn = document.createElement("button");
                btn.id = "create";
                btn.innerHTML = "create";
                btn.onclick = function () {
                    var caption =
                        document.getElementById("caption_create").value;
                    var note = document.getElementById("note_create").value;
                    var author = document.getElementById("author_create").value;
                    var city = document.getElementById("city_create").value;

                    var createdDate = new Date(Date.now());
                    createdDate.toISOString().split("T")[0];

                    Async("create", {
                        caption: caption,
                        note: note,
                        author: author,
                        city: city,
                        created: createdDate,
                    });
                };
                td.appendChild(btn);
            }

            trItem.appendChild(td);
        }
    });
    table.appendChild(trItem);
}
