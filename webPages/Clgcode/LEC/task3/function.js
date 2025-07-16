// function of add,sub,multi,division
function add(a, b) {
    return a + b;
}
function sub(a, b) {
    return a - b;
}   
function multi(a, b) {
    return a * b;
}
function division(a, b) {
    if (b === 0) {
        console.error("Division by zero is not allowed.");
        return undefined; // or throw an error
    }
    return a / b;
}
function myfun() {
    var str = "urval.kheni_";
    let str2 = 777;
    const str3 = "Hello From Urval";
    // const firstName ;
    // console.log(firstName);
    firstName = "Urval";
    console.log(firstName);
    console.log(str);
    console.log(str2);
    console.log(str3);
    if(1){
        str = "Urval";
        console.log(str);
        str2 = 3;
        console.log(str2);
        const str3 = "Hello";
        console.log(str3);

    }
    console.log(str);
    console.log(str2);
    console.log(str3);
}
