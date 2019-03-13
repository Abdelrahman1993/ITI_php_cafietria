
let orderCount = document.getElementById('orderCount');
let incrementBtn = document.getElementsByClassName('increment');
let decrementBtn = document.getElementsByClassName('decrement');
let removeBtn = document.getElementsByClassName('remove')
let orderImage = document.getElementsByClassName('imgSize');
let orders = document.getElementById('orders');
let totalPrice = document.getElementById('totalPrice');
let priceSpan = document.getElementsByClassName('productPrice');
let searchInput = document.getElementById('search');
let orderList = document.getElementsByClassName('orderList');
let priceInput = document.getElementById('priceInput');
let userOrderData = document.getElementById('order_data');
let totalP;
let orderData = {};
let flag = 0;

searchInput.addEventListener('keyup', () => {
    console.log("search");
    let productList = document.getElementsByClassName('productName');
    let filter = searchInput.value.toUpperCase();
    for (let i = 0; i < productList.length; i++) {
        let txtValue = productList[i].textContent || productList[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            productList[i].parentElement.style.display = "";
        } else {
            productList[i].parentElement.style.display = "none";
        }
    }
});

for (let i = 0; i < orderImage.length; i++) {
    orderImage[i].addEventListener('click', (event) => {
        orderImage[i].style.pointerEvents = "none";

        totalP = event.target.alt;
        let myorder = document.createElement('div');
        myorder.setAttribute('class', 'orderList');
        myorder.setAttribute('name', 'order_list');

        // let hiddenInput=document.createElement('input');
        // hiddenInput.setAttribute('type','hidden');
        // hiddenInput.setAttribute('name','orderData');
        // hiddenInput.appendChild(document.createTextNode( JSON.stringify(orderData)));
        // myorder.appendChild(hiddenInput);

        let name = document.createElement('span');
        name.setAttribute('name', 'order_name');
        name.appendChild(document.createTextNode(event.target.name));


        let count = document.createElement('span');
        count.setAttribute('class', 'orderCount');
        count.setAttribute('name', 'order_count');
        count.appendChild(document.createTextNode("1"))

        myorder.appendChild(name);
        myorder.appendChild(count);

        let ord_name = event.target.name;
        // Object.assign(orderData, { ord_name: count.innerHTML });
        console.log(count.innerHTML);
        orderData[ord_name] = count.innerHTML;
        userOrderData.value = JSON.stringify(orderData);
        // console.log("sdsd = " +JSON.stringify(orderData) );
        let plusBtn = document.createElement('button');
        plusBtn.setAttribute('type', 'button');
        plusBtn.setAttribute('id', event.target.id);
        plusBtn.setAttribute('class', 'btn btn-info increment');
        let spanPlusBtn = document.createElement('span');
        spanPlusBtn.setAttribute('class', 'glyphicon glyphicon-plus')
        plusBtn.appendChild(spanPlusBtn);
        plusBtn.onclick = (event2) => {
            incrementAction(event, event2);
        };
        myorder.appendChild(plusBtn);

        let minusBtn = document.createElement('button');
        minusBtn.setAttribute('type', 'button');
        minusBtn.setAttribute('class', 'btn btn-info decrement');
        let spanMinusBtn = document.createElement('span');
        spanMinusBtn.setAttribute('class', 'glyphicon glyphicon-minus')
        minusBtn.appendChild(spanMinusBtn);

        minusBtn.onclick = (event2) => {
            decrementAction(event, event2);
        }
        myorder.appendChild(minusBtn);

        let EGP = document.createElement('span');
        EGP.appendChild(document.createTextNode("EGP"))
        myorder.appendChild(EGP);

        let price = document.createElement('span');
        price.setAttribute('class', 'productPrice');
        price.appendChild(document.createTextNode(totalP))
        myorder.appendChild(price);

        let removeBtn = document.createElement('button');
        removeBtn.setAttribute('type', 'button');
        removeBtn.setAttribute('class', 'btn btn-default remove');
        let spanremoveBtn = document.createElement('span');
        spanremoveBtn.setAttribute('class', 'glyphicon glyphicon-remove')
        removeBtn.appendChild(spanremoveBtn);
        removeBtn.onclick = (event2) => {
            orderImage[i].style.pointerEvents = "auto";
            let ord_name = event.target.name;
            delete orderData[ord_name];
            userOrderData.value = JSON.stringify(orderData);
            // console.log("sdsd = " +JSON.stringify(orderData) );
            removeAction(event2)
        };
        myorder.appendChild(removeBtn);

        orders.appendChild(myorder);
        calculateTotalPrice();
    });
}

function calculateTotalPrice() {
    let total = 0;
    for (let i = 0; i < priceSpan.length; i++) {
        console.log(priceSpan[i]);
        total += parseInt(priceSpan[i].innerHTML);
    }
    totalPrice.innerHTML = total;
    priceInput.value = total;
}

function incrementAction(event, event2) {
    // console.log("hello");
    // console.log(event2.target.previousElementSibling.innerHTML);
    let val = parseInt(event2.target.previousElementSibling.innerHTML);
    val++;
    totalP = val * parseInt(event.target.alt);
    event2.target.parentElement.childNodes[5].innerHTML = totalP;
    console.log(event2.target.parentElement);
    console.log("total = " + totalP);
    event2.target.previousElementSibling.innerHTML = val;
    let ord_name = event.target.name;
    orderData[ord_name] = val;
    userOrderData.value = JSON.stringify(orderData);
    // console.log("sdsd = " +JSON.stringify(orderData) );
    // console.log("ord = " + ord_name);
    calculateTotalPrice();
}

function decrementAction(event, event2) {
    // console.log(event2.target.previousElementSibling.previousElementSibling.innerHTML);
    let val = parseInt(event2.target.previousElementSibling.previousElementSibling.innerHTML);
    if (val > 0) {
        val--;
        totalP = val * parseInt(event.target.alt);
        event2.target.parentElement.childNodes[5].innerHTML = totalP;
        console.log(event.target.parentElement.childNodes[5]);
        console.log("total = " + totalP);
        event2.target.previousElementSibling.previousElementSibling.innerHTML = val;
        let ord_name = event.target.name;
        orderData[ord_name] = val;
        userOrderData.value = JSON.stringify(orderData);
        // console.log("ord = " + ord_name);
        // console.log("sdsd = " +JSON.stringify(orderData) ); 
    }
    calculateTotalPrice();
}

function removeAction(event2) {
    event2.target.parentElement.remove();
    calculateTotalPrice();
}
// function save_user_order(){
    // sessionStorage.setItem("orderData", JSON.stringify(orderData));
    // window.location.href="saveOrder.php?data="+JSON.stringify(orderData);
// }

