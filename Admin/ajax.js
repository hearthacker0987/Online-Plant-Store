 $(document).ready(function () {
    // Search Parent Category 
    $('#cate_search_input').keyup(function () {
        let parent_cate_search = $(this).val().toLowerCase();
        let Row = $('#parent_cate_table tbody tr');
        for (let i = 0; i < Row.length; i++) {
            let column = $(Row[i]).text().toLowerCase();
            if(column.indexOf(parent_cate_search) === -1){
                $(Row[i]).fadeOut();
            }
            else{
                $(Row[i]).fadeIn();
            }            
        }
    });
    // Search Sub Category 
    $('#sub_cate_search').keyup(function () {
        let sub_cate_search = $(this).val().toLowerCase();
        let Row = $('#sub_cate_table tbody tr');
        for (let i = 0; i < Row.length; i++) {
            let column = $(Row[i]).text().toLowerCase();
            if(column.indexOf(sub_cate_search) === -1){
                $(Row[i]).fadeOut();
            }
            else{
                $(Row[i]).fadeIn();
            }            
        }
    });

    // Search Products
    $('#prod_search_input').keyup(function () {
        let cate_search = $(this).val().toLowerCase();
        let Row = $('#product_table tbody tr');
        for (let i = 0; i < Row.length; i++) {
            let column = $(Row[i]).text().toLowerCase();
            if(column.indexOf(cate_search) === -1){
                $(Row[i]).fadeOut();
            }
            else
            {
                $(Row[i]).fadeIn();
            }            
        }
    });
    // Search Users
    $('#user_search_input').keyup(function () {
        let user_search = $(this).val().toLowerCase();
        let Row = $('#user_table tbody tr');
        for (let i = 0; i < Row.length; i++) {
            let column = $(Row[i]).text().toLowerCase();
            if(column.indexOf(user_search) === -1){
                $(Row[i]).fadeOut();
            }
            else
            {
                $(Row[i]).fadeIn();
            }            
        }
    });
    // Search Orders
    $('#search_order_input').keyup(function(){
        let search_order = $(this).val().toLowerCase();
        let Row = $('#order_table tbody tr');
        for(let i = 0; i < Row.length; i++){
            let column = $(Row[i]).text().toLowerCase();
            if(column.indexOf(search_order) === -1){
                $(Row[i]).fadeOut()
            }
            else{
                $(Row[i]).fadeIn();
            }
        }
    })
    // Search Feedback
    $('#search_feedback_input').keyup(function(){
        let search_feedback = $(this).val().toLowerCase();
        let Row = $('#feedback_table tbody tr');
        for(let i = 0; i < Row.length; i++){
            let column = $(Row[i]).text().toLowerCase();
            if(column.indexOf(search_feedback) === -1){
                $(Row[i]).fadeOut()
            }
            else{
                $(Row[i]).fadeIn();
            }
        }
    })
    // Mark orders 
    $('.mark_orders').on('change',function(){
        let status = $(this).val();
        let order_id = $(this).closest('tr').find('.order_id').text();
        // let products = $(this).closest('tr').find('.products').text();
        $.ajax({
            url: 'code.php',
            method: 'post',
            data: {
                'markOrderStatus' : true,
                status : status,
                order_id : order_id
            },
            success: function(response){
                location.reload();
            }
        })      
    });
    $('.replyBtn').on('click', function(e){
        e.preventDefault();
        console.log('fed')
        let feedback_id =  $(this).closest('tr').find('.fb_id').text();
        console.log(feedback_id)
        $('.feedback_id_input').val(feedback_id);
        $('#replyModal').modal('show');

    });

    if($('.message')){
        setTimeout(()=>
        {
        $('.message').fadeOut();
        }, 5000);
    }
}); 