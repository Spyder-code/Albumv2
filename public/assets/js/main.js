console.log("tes");

function drag(evt) {
    evt.dataTransfer.setData("text", evt.target.id);
}

function drop(evt) {
    evt.preventDefault();
    var data = evt.dataTransfer.getData("text");
    var image = document.getElementById(data);
    evt.target.appendChild(image);
    let target = event.target;
    if (target.id === "picture") {
        evt.preventDefault();
        var data = evt.dataTransfer.getData("text");
        var image = document.getElementById(data);
        evt.target.appendChild(image);
    }
}

function allowDrop(evt) {
    evt.preventDefault();
}
