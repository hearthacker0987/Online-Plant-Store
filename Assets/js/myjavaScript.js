// Code For Total Price 
let carts = document.getElementsByClassName('addToCartBody');
let quantities = document.getElementsByClassName('quantityCount');
let gtotal= document.getElementById('gt');
function total(){
    let prices = document.getElementsByClassName('db_price');
    gt = 0
    for (let i = 0; i < carts.length; i++) {
        
        gt = gt+parseInt(prices[i].textContent);
    }
    gtotal.textContent = gt;     
}
if(gtotal){
    total();
}
// For Increment & Decrement the AddToCart Values 
let body = document.querySelectorAll('.addToCardList');
body.forEach(element=>{
    let decrementBtn = element.querySelector('.decrement');
    let incrementBtn = element.querySelector('.increment');
    let quantityInput = element.querySelector('.quantityCount');
    let prod_id = element.querySelector('.prod_id').value;
    // Update Price Function 
    function updatePrice()
    {
        let quantityInput = element.querySelector('.quantityCount').value;
        let price = element.querySelector('.prod_price').value;
        let inputValue = parseInt(quantityInput);
        if(quantityInput != ''){
            let totlePrice = price*inputValue;
            element.querySelector('.db_price').textContent = totlePrice;
            total();
        }
    }
    // For Decrement Values
    decrementBtn.addEventListener('click',function (){
        var currentValue = quantityInput.value;
        // checking value greater then 0 
        if(currentValue > 0){
            currentValue--;
            quantityInput.value = currentValue;
            updatePrice();
            updateDbQuantity(prod_id,quantityInput.value);
        }
        else{
            quantityInput.value = 0;
        }

    })
    // For Increment Values 
    incrementBtn.addEventListener('click',function (){
        var currentValue = quantityInput.value;
        currentValue++;
        quantityInput.value = currentValue;
        updatePrice();
        updateDbQuantity(prod_id,quantityInput.value);
    })
    // For when keyup on input field 
    quantityInput.addEventListener('keyup',function(){
        if(this.value < 0 || this.value <= -1){
            this.value = 0;
        }
        updatePrice();
        updateDbQuantity(prod_id,quantityInput.value);
    })
    updatePrice(prod_id,quantityInput.value);
})

// When Click on remove cart button
function removeItem(product_id){
    $.ajax({
        url: 'code.php',
        method: 'post',
        data: {
            'removeProductFromCart': true,
            product_id: product_id
        },
        success: function(response){
            location.reload();
        }
    })
}
function updateDbQuantity(prod_id,productQuantity){
    $.ajax({
        url: 'code.php',
        method: 'post',
        data: {
            'updateQuantity' : true,
            prod_id:prod_id,
            quantity: productQuantity
        },
        success:function(response){
        }
    })
};     
$(document).ready(function(){
// When Click on Add to Cart Button Which Is On The Products
    $('.addToCardProdBtn').on('click',function (e) {
        e.preventDefault();
        let prod_id = $(this).find('input').val();
        $('.addToCardProdLoading').show();
        function addToCartAjax(){
            $.ajax({
                url: 'code.php',
                method: 'post',
                data: {
                    'addToCardProdBtn' : true,
                    prod_id : prod_id
                },
                success: function(response){
                    if(response == 0){
                        window.location.href = "Login.php";
                    }
                    else{
                        location.reload();
                    }
                },
                complete:function (){
                    $('.addToCardProdLoading').hide();
                }
            });
        }
        setTimeout(() => {
            addToCartAjax();
        }, 600);
    })


});