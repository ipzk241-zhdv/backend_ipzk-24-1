window.onload = function () {
    var redirect = document.getElementById("basket");
    redirect.onclick = function () {
        Async("confirm");
    };

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
            if (response.status === 303) {
                window.location.href = "basket.php";
            }
            else if (!response.ok) {
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
            var toDelete = document.getElementsByClassName("row");
            if (toDelete != null) {
                for (var i = 0; i < toDelete.length; i) {
                    toDelete[i].parentNode.removeChild(toDelete[i]);
                }
            }

            var parent = document.getElementById("content");

            for (var i = 0; i < jsonData.length; i++) {
                if (i % 4 == 0 || i == 0) {
                    var row = document.createElement("div");
                    row.classList.add("row");
                    parent.appendChild(row);
                }

                var item = document.createElement("div");
                item.classList.add("item");
                item.id = "item_" + jsonData[i]["id"];

                item.onclick = function () {
                    var id = this.id;
                    id = id.match(/\d+/g)[0];

                    Async("addItem", {
                        id: id,
                    });
                };

                var caption = document.createElement("div");
                var cost = document.createElement("div");
                var description = document.createElement("div");

                var caption_content = document.createElement("p");
                var cost_content = document.createElement("p");
                var description_content = document.createElement("p");

                caption_content.innerHTML = jsonData[i]["name"];
                cost_content.innerHTML = jsonData[i]["cost"];
                description_content.innerHTML = jsonData[i]["description"];

                caption.appendChild(caption_content);
                cost.appendChild(cost_content);
                description.appendChild(description_content);

                item.appendChild(caption);
                item.appendChild(description);
                item.appendChild(cost);

                row.appendChild(item);
            }
        })
        .catch((error) => {
            console.error(
                "There has been a problem with your fetch operation:",
                error
            );
        });
}
