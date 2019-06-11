var Animals = [
    "Dog", 
    "Cat", 
    "Hamster",
    "Rabbit",
    "Bird",
    "Television",
    "Car",
    "Brick",
    "Bottle",
    "... Human?"
]

function percentageA() {
    var x = document.getElementById("myRange").value;
    document.getElementById("a").innerHTML = x + '%';
}

function percentageB() {
    var x = document.getElementById("otherRange").value;
    document.getElementById("b").innerHTML = x + '%';
}

function otherType(name) {
    var string = "";
    string += '<select class="form-"control" id="petType" type="text" name="petType" required>';
    for (let i = 0; i < Animals.length; i++) {
        string += '<option value="';
        string += Animals[i] + '">' + Animals[i] + '</option>';
    }
    string += '</select>';
    var slider = "";
    slider += '<div class="slidecontainer">';
    slider += '<p>How much of a ' + string + ' is ' + name + '?</p>';
    slider += '<input name="animal_B" onChange="otherTypeValue()" type="range" min="1" max="100" value="100" class="slider" id="otherRange"><h1 id="b">100%</h1>';
    slider += '</div>';
    var x = document.getElementById("myRange").value;
    var all = "";
    if (parseInt(x) < "60") {
        all = all + '<div id="other">';
        all += slider;
        all = all + '</div>';
        document.getElementById("other").innerHTML = all;
    } else {
        document.getElementById("other").innerHTML = '<div id="other"></div></div>';
    }
    document.getElementById("a").innerHTML = x + '%';
}

function otherTypeValue() {
    var x = document.getElementById("otherRange").value;
    document.getElementById("b").innerHTML = x + '%';
}