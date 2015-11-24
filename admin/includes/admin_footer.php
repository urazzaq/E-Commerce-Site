 </div>
            <footer class = "text-center" id="footer">&copy; Copyright 2015-2017 Umer's E-Commerce World</footer>	
            <script>
                function updateSizes(){
                    var sizeString ='';
                    for(var i=1;i<=6;i++){
                        if($('#size'+i).val()!== ''){
                            sizeString+= $('#size'+i).val()+':'+$('#qty'+i).val()+',';
                        }     
                    }
                    $('#sizes').val(sizeString);
                }
                
                function get_child_options(){
                    var parentID = $('#parent').val();
                    var data = {'parentID':parentID};
                    $.ajax({
                        url: './child_categories.php',
                        type: 'POST',
                        data: data,
                        success: function(data){
                            $('#child').html(data);
                        },
                        error: function(){}
                    });
                }
                $('select[name="parent"]').change(get_child_options);
            </script>
    </body>
</html>