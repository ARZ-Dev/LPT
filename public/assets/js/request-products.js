
    var _token= $("input[name='_token']").val(); 

    function addProductList(productId){

        $.ajax({
            url: '/product/listAdd',
            type: 'post',
            data: {"_token":_token , "productId":productId},
            success: function(data){ ;
                
                var productBtn=$(".product-"+productId).find(".addListBtn"); 

                if($(productBtn).hasClass('bi-plus-square')) {
                    $(productBtn).removeClass('bi-plus-square').addClass('bi-dash-square');

                }else{
                    $(productBtn).removeClass('bi-dash-square').addClass('bi-plus-square');
                }

                getAllProducts();

            },error: function(xhr, status, error) {
                // alert(xhr.responseText);
            }
        });
    }
    

    function getAllProducts(){
        $.ajax({
            url: '/product/listAll',
            type: 'post',
            data: {"_token":_token },
            success: function(data){ 
                $(".allRequestedProducts").html(data);
                getProductsNum();
                activateRemoveProduct();
                checkAddedProducts();
            },error: function(xhr, status, error) {
                // alert(xhr.responseText);
            }
        });
    }


    function getProductsNum(){
        var numb=$(".allRequestedProducts").first().find("li").length;
        $(".product-request-number").text(numb);
    }


    function activateRemoveProduct(){
        $(".removeListProductBtn").on('click',function(){  
            var productId=$(this).attr("productId");
            addProductList(productId);
        });
    }


  

    function checkAddedProducts() {

        var allRequestedProducts = $('.allRequestedProducts');
        var requestButton = $('.requestButtons');
        var langJs = $('.lang-js'); // Use class instead of id
        var noItemsSelected = $('.NoItemsSelected');

        if (allRequestedProducts.children().length === 0) {
            requestButton.prop('disabled', true);

            if (langJs.attr('langjs') === 'EN') {
                noItemsSelected.text('No Items Selected');
            } else {
                noItemsSelected.text('لا يوجد منتوجات محددة');
            }

        } 
        else{
            requestButton.removeAttr('disabled');


            if (langJs.attr('langjs') === 'EN') {
                noItemsSelected.text('Items');
            } else {
                noItemsSelected.text('المنتجات');
            }
            

        }

    }

    
    $(window).on('load', function () {
        
        getAllProducts();
        
        $(".removeProductBtn").on('click',function(){  
            var productId=$(this).attr("productId");
            addProductList(productId);
            setTimeout(() => {
                location.reload();
            }, 250);
        });
    
       
    });
