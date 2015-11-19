<!--Background logo-->
<script>
            var vscroll = jQuery(this).scrollTop(); // assigns vscroll to scroll top
            jQuery("#logo").css({
    jQuery(window).scroll(function(){ "transform" : "translate(0px, " + vscroll / 3 + "px)";
    });
    });
</script>

<!--Details Modal Function-->
<script> 
    
    function detailsModal(id){
        var data ={"id":id };
            jQuery.ajax({
                url:'./DetailsModal.php',
                method : "post",
                data : data,
                success : function(data){
                jQuery('body').append(data);
                jQuery('#details-modal').modal('toggle');
                },
                error : function(){
                    alert("error!");
                }
            });
       
    }
</script>
<footer class = "text-center" id="footer">&copy; Copyright 2015-2017 E-Commerce World</footer>	