
let orderCount = document.getElementById('orderCount');
let incrementBtn = document.getElementsByClassName('increment');
let decrementBtn = document.getElementsByClassName('decrement');
let removeBtn = document.getElementsByClassName('remove')
let orderImage = document.getElementsByClassName('imgSize');
let orders = document.getElementById('orders');
let totalPrice = document.getElementById('totalPrice');
let priceSpan = document.getElementsByClassName('productPriceAdmin');
let searchInput = document.getElementById('search');
let orderList = document.getElementsByClassName('orderList');
let priceInput = document.getElementById('priceInput');
let userorderDataAdmin = document.getElementById('order_data');
let totalP;


if (localStorage.getItem('productPriceAdmin') == null) {
    var productPriceAdmin = {};
} else {
    var productPriceAdmin = JSON.parse(localStorage.getItem('productPriceAdmin'));
}

if (localStorage.getItem('totalproductPriceAdmin') == null) {
    var totalproductPriceAdmin = {};
} else {
    var totalproductPriceAdmin = JSON.parse(localStorage.getItem('totalproductPriceAdmin'));
}

if (localStorage.getItem('orderDataAdmin') == null) {
    var orderDataAdmin = {};
} else {
    var orderDataAdmin = JSON.parse(localStorage.getItem('orderDataAdmin'));
    renderElement(orderDataAdmin,productPriceAdmin,totalproductPriceAdmin);
}


if (localStorage.getItem('clickableImageAdmin') == null) {
    var clickableImageAdmin = {};
} else {
    var clickableImageAdmin = JSON.parse(localStorage.getItem('clickableImageAdmin'));
    img_click(clickableImageAdmin);
}

searchInput.addEventListener('keyup', () => {
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
        clickableImageAdmin[event.target.name] = 'none';
        localStorage.setItem('clickableImageAdmin', JSON.stringify(clickableImageAdmin));
        console.log("clicabel = " + localStorage.getItem('clickableImageAdmin'));
        totalP = event.target.alt;
        let myorder = document.createElement('div');
        myorder.setAttribute('class', 'orderList');
        myorder.setAttribute('name', 'order_list');

        let name = document.createElement('span');
        name.setAttribute('name', 'order_name');
        name.setAttribute('id', event.target.alt);
        name.appendChild(document.createTextNode(event.target.name));
        productPriceAdmin[event.target.name]=event.target.alt;
        localStorage.setItem('productPriceAdmin',JSON.stringify(productPriceAdmin));
         
        totalproductPriceAdmin[event.target.name]=totalP;
        localStorage.setItem('totalproductPriceAdmin',JSON.stringify(totalproductPriceAdmin));
        
        let count = document.createElement('span');
        count.setAttribute('class', 'orderCount');
        count.setAttribute('name', 'order_count');
        count.appendChild(document.createTextNode("1"))

        myorder.appendChild(name);
        myorder.appendChild(count);

        let ord_name = event.target.name;
        console.log(count.innerHTML);
        orderDataAdmin[ord_name] = count.innerHTML;
        userorderDataAdmin.value = JSON.stringify(orderDataAdmin);
        localStorage.setItem('orderDataAdmin', JSON.stringify(orderDataAdmin));
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
        price.setAttribute('class', 'productPriceAdmin');
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
            delete orderDataAdmin[ord_name];
            userorderDataAdmin.value = JSON.stringify(orderDataAdmin);
            localStorage.setItem('orderDataAdmin', JSON.stringify(orderDataAdmin));
            clickableImageAdmin[ord_name] = 'auto';
            localStorage.setItem('clickableImageAdmin', JSON.stringify(clickableImageAdmin));
            console.log("aaaa = " + localStorage.getItem('clickableImageAdmin'));
            removeAction(event2);
            img_click(clickableImageAdmin);
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
    orderDataAdmin[ord_name] = val;

    totalproductPriceAdmin[ord_name]=totalP;
    localStorage.setItem('totalproductPriceAdmin',JSON.stringify(totalproductPriceAdmin));

    userorderDataAdmin.value = JSON.stringify(orderDataAdmin);
    localStorage.setItem('orderDataAdmin', JSON.stringify(orderDataAdmin));
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
        orderDataAdmin[ord_name] = val;
        totalproductPriceAdmin[ord_name]=totalP;
        localStorage.setItem('totalproductPriceAdmin',JSON.stringify(totalproductPriceAdmin));

        userorderDataAdmin.value = JSON.stringify(orderDataAdmin);
        localStorage.setItem('orderDataAdmin', JSON.stringify(orderDataAdmin));
    }
    calculateTotalPrice();
}

function removeAction(event2) {
    event2.target.parentElement.remove();
    calculateTotalPrice();
}

function renderElement(orderDataAdmin,productPriceAdmin,totalproductPriceAdmin) {
    Object.keys(orderDataAdmin).forEach(function (key) {
        console.log('Key : ' + key + ', Value : ' + orderDataAdmin[key])
        let myorder = document.createElement('div');
        myorder.setAttribute('class', 'orderList');
        myorder.setAttribute('name', 'order_list');

        let name = document.createElement('span');
        name.setAttribute('name', 'order_name');
         name.setAttribute('id', productPriceAdmin[key]);
        name.appendChild(document.createTextNode(key));


        let count = document.createElement('span');
        count.setAttribute('class', 'orderCount');
        count.setAttribute('name', 'order_count');
        count.appendChild(document.createTextNode(orderDataAdmin[key]))

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
        price.setAttribute('class', 'productPriceAdmin');
        price.appendChild(document.createTextNode(totalproductPriceAdmin[key]));
        myorder.appendChild(price);

        let removeBtn = document.createElement('button');
        removeBtn.setAttribute('type', 'button');
        removeBtn.setAttribute('class', 'btn btn-default remove');
        let spanremoveBtn = document.createElement('span');
        spanremoveBtn.setAttribute('class', 'glyphicon glyphicon-remove')
        removeBtn.appendChild(spanremoveBtn);
        removeBtn.onclick = (event2) => {

            let ord_name = event2.target.parentElement.childNodes[0].innerHTML;
            delete orderDataAdmin[ord_name];
            userorderDataAdmin.value = JSON.stringify(orderDataAdmin);
            localStorage.setItem('orderDataAdmin', JSON.stringify(orderDataAdmin));
            event2.target.style.pointerEvents='auto';
            clickableImageAdmin[ord_name] = 'auto';
            localStorage.setItem('clickableImageAdmin', JSON.stringify(clickableImageAdmin));
            console.log("aaaa = " + localStorage.getItem('clickableImageAdmin'));
            removeAction(event2);
            img_click(clickableImageAdmin);
        };
        myorder.appendChild(removeBtn);
        orders.appendChild(myorder);
        calculateTotalPrice();
    })

}
function img_click(clickableImageAdmin) {
    Object.keys(clickableImageAdmin).forEach(function (key) {
        console.log('Key : ' + key + ', Value : ' + clickableImageAdmin[key])
        for(let a=0;a<orderImage.length;a++){
            if(orderImage[a].name==key){
            orderImage[a].style.pointerEvents = clickableImageAdmin[key];
            }
        }

    });
}
