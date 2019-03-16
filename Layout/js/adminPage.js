
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
let flag = 0;

if (localStorage.getItem('productPriceAdmin') == null) {
    var productPrice = {};
} else {
    var productPrice = JSON.parse(localStorage.getItem('productPriceAdmin'));
}

if (localStorage.getItem('totalProductPriceAdmin') == null) {
    var totalProductPrice = {};
} else {
    var totalProductPrice = JSON.parse(localStorage.getItem('totalProductPriceAdmin'));
}

if (localStorage.getItem('orderDataAdmin') == null) {
    var orderData = {};
} else {
    var orderData = JSON.parse(localStorage.getItem('orderDataAdmin'));
    renderElement(orderData,productPrice,totalProductPrice);
}


if (localStorage.getItem('clickableImageAdmin') == null) {
    var clickableImage = {};
} else {
    var clickableImage = JSON.parse(localStorage.getItem('clickableImageAdmin'));
    img_click(clickableImage);
}

searchInput.addEventListener('keyup', () => {

    let productList = document.getElementsByClassName('productName');
    let filter = searchInput.value.toUpperCase();
    console.log(productList);
    for (let i = 0; i < productList.length; i++) {
        let txtValue = productList[i].textContent || productList[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            productList[i].parentElement.parentElement.parentElement.style.display = "";
        } else {

            productList[i].parentElement.parentElement.parentElement.style.display = "none";
        }
    }
});

for (let i = 0; i < orderImage.length; i++) {
    orderImage[i].addEventListener('click', (event) => {
        orderImage[i].style.pointerEvents = "none";

        clickableImage[event.target.name] = 'none';
        localStorage.setItem('clickableImageAdmin', JSON.stringify(clickableImage));
        console.log("clicabel = " + localStorage.getItem('clickableImageAdmin'));
        totalP = event.target.alt;
        let myorder = document.createElement('div');
        myorder.setAttribute('class', 'orderList table');
        myorder.setAttribute('name', 'order_list');



        let name = document.createElement('span');
        name.setAttribute('name', 'order_name');
        name.setAttribute('id', event.target.alt);
        name.appendChild(document.createTextNode(event.target.name));
        productPrice[event.target.name]=event.target.alt;
        localStorage.setItem('productPriceAdmin',JSON.stringify(productPrice));
         
        totalProductPrice[event.target.name]=totalP;
        localStorage.setItem('totalProductPriceAdmin',JSON.stringify(totalProductPrice));
        
        let count = document.createElement('span');
        count.setAttribute('class', 'orderCount mg');
        count.setAttribute('name', 'order_count');
        count.appendChild(document.createTextNode("1"))

        myorder.appendChild(name);
        myorder.appendChild(count);

        let ord_name = event.target.name;
        // Object.assign(orderData, { ord_name: count.innerHTML });

        console.log(count.innerHTML);
        orderData[ord_name] = count.innerHTML;
        userOrderData.value = JSON.stringify(orderData);
        localStorage.setItem('orderDataAdmin', JSON.stringify(orderData));

        let plusBtn = document.createElement('button');
        plusBtn.setAttribute('type', 'button');
        plusBtn.setAttribute('id', event.target.id);
        plusBtn.setAttribute('class', 'btn btn-info increment');
        let spanPlusBtn = document.createElement('span');
        spanPlusBtn.setAttribute('class', 'glyphicon glyphicon-plus')
        plusBtn.appendChild(spanPlusBtn);
        plusBtn.onclick = (event2) => {

            incrementAction(event2);
        };
        myorder.appendChild(plusBtn);

        let minusBtn = document.createElement('button');
        minusBtn.setAttribute('type', 'button');
        minusBtn.setAttribute('class', 'btn btn-info decrement');
        let spanMinusBtn = document.createElement('span');
        spanMinusBtn.setAttribute('class', 'glyphicon glyphicon-minus')
        minusBtn.appendChild(spanMinusBtn);

        minusBtn.onclick = (event2) => {

            decrementAction(event2);
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

            localStorage.setItem('orderDataAdmin', JSON.stringify(orderData));
            clickableImage[ord_name] = 'auto';
            localStorage.setItem('clickableImageAdmin', JSON.stringify(clickableImage));
            console.log("aaaa = " + localStorage.getItem('clickableImageAdmin'));
            removeAction(event2);
            img_click(clickableImage);
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


function incrementAction(event2) {
    let val = parseInt(event2.target.previousElementSibling.innerHTML);
    val++;
    totalP = val * event2.target.parentElement.childNodes[0].attributes.id.value;
    event2.target.parentElement.childNodes[5].innerHTML = totalP;
    event2.target.previousElementSibling.innerHTML = val;
    let ord_name = event2.target.parentElement.childNodes[0].innerHTML;
    orderData[ord_name] = val;

    totalProductPrice[ord_name]=totalP;
    localStorage.setItem('totalProductPriceAdmin',JSON.stringify(totalProductPrice));

    userOrderData.value = JSON.stringify(orderData);
    localStorage.setItem('orderDataAdmin', JSON.stringify(orderData));
    calculateTotalPrice();
}

function decrementAction(event2) {
    let val = parseInt(event2.target.parentElement.childNodes[1].innerHTML);
    if (val > 0) {
        val--;
        totalP = val * event2.target.parentElement.childNodes[0].attributes.id.value;
        event2.target.parentElement.childNodes[5].innerHTML = totalP;
        event2.target.parentElement.childNodes[1].innerHTML = val;
        let ord_name = event2.target.parentElement.childNodes[0].innerHTML;
        orderData[ord_name] = val;
        totalProductPrice[ord_name]=totalP;
        localStorage.setItem('totalProductPriceAdmin',JSON.stringify(totalProductPrice));

        userOrderData.value = JSON.stringify(orderData);
        localStorage.setItem('orderDataAdmin', JSON.stringify(orderData));
    }
    calculateTotalPrice();
}

function removeAction(event2) {
    event2.target.parentElement.remove();
    calculateTotalPrice();
}


function renderElement(orderData,productPrice,totalProductPrice) {
    Object.keys(orderData).forEach(function (key) {
        console.log('Key : ' + key + ', Value : ' + orderData[key])
        let myorder = document.createElement('div');
        myorder.setAttribute('class', 'orderList');
        myorder.setAttribute('name', 'order_list');

        let name = document.createElement('span');
        name.setAttribute('name', 'order_name');
         name.setAttribute('id', productPrice[key]);
        name.appendChild(document.createTextNode(key));


        let count = document.createElement('span');
        count.setAttribute('class', 'orderCount');
        count.setAttribute('name', 'order_count');
        count.appendChild(document.createTextNode(orderData[key]))

        myorder.appendChild(name);
        myorder.appendChild(count);

        let plusBtn = document.createElement('button');
        plusBtn.setAttribute('type', 'button');
        plusBtn.setAttribute('class', 'btn btn-info increment');
        let spanPlusBtn = document.createElement('span');
        spanPlusBtn.setAttribute('class', 'glyphicon glyphicon-plus')
        plusBtn.appendChild(spanPlusBtn);
        plusBtn.onclick = (event2) => {
            incrementAction(event2);
        };
        myorder.appendChild(plusBtn);

        let minusBtn = document.createElement('button');
        minusBtn.setAttribute('type', 'button');
        minusBtn.setAttribute('class', 'btn btn-info decrement');
        let spanMinusBtn = document.createElement('span');
        spanMinusBtn.setAttribute('class', 'glyphicon glyphicon-minus')
        minusBtn.appendChild(spanMinusBtn);

        minusBtn.onclick = (event2) => {
            decrementAction(event2);
        }
        myorder.appendChild(minusBtn);

        let EGP = document.createElement('span');
        EGP.appendChild(document.createTextNode("EGP"))
        myorder.appendChild(EGP);

        let price = document.createElement('span');
        price.setAttribute('class', 'productPrice');
        price.appendChild(document.createTextNode(totalProductPrice[key]));
        myorder.appendChild(price);

        let removeBtn = document.createElement('button');
        removeBtn.setAttribute('type', 'button');
        removeBtn.setAttribute('class', 'btn btn-default remove');
        let spanremoveBtn = document.createElement('span');
        spanremoveBtn.setAttribute('class', 'glyphicon glyphicon-remove')
        removeBtn.appendChild(spanremoveBtn);
        removeBtn.onclick = (event2) => {

            let ord_name = event2.target.parentElement.childNodes[0].innerHTML;
            delete orderData[ord_name];
            userOrderData.value = JSON.stringify(orderData);
            localStorage.setItem('orderDataAdmin', JSON.stringify(orderData));
            event2.target.style.pointerEvents='auto';
            clickableImage[ord_name] = 'auto';
            localStorage.setItem('clickableImageAdmin', JSON.stringify(clickableImage));
            console.log("aaaa = " + localStorage.getItem('clickableImageAdmin'));
            removeAction(event2);
            img_click(clickableImage);
        };
        myorder.appendChild(removeBtn);
        orders.appendChild(myorder);
        calculateTotalPrice();
    })

}
function img_click(clickableImage) {
    Object.keys(clickableImage).forEach(function (key) {
        console.log('Key : ' + key + ', Value : ' + clickableImage[key])
        for (let a = 0; a < orderImage.length; a++) {
            if (orderImage[a].name == key) {
                orderImage[a].style.pointerEvents = clickableImage[key];
            }
        }

    });
}
