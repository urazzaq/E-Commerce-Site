 </div>
            <footer class = "text-center" id="footer">&copy; Copyright 2015-2017 Umer's E-Commerce World</footer>	
            <script>
                //build sizestring to show sizes 
                function updateSizes(){
                    var sizeString ='';
                    for(var i=1;i<=6;i++){
                        if($('#size'+i).val()!== ''){
                            sizeString+= $('#size'+i).val()+':'+$('#qty'+i).val()+',';
                        }     
                    }
                    $('#sizes').val(sizeString);
                }
                //populate dropdown with the child catagory depending on what parent category is
                function get_child_options(selected){
                    if(typeof selected === "undefined"){
                        var selected = '';
                    }
                    
                    var parentID = $('#parent').val();
                    var data = {'parentID':parentID, 'selected': selected};
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
                $('select[name="parent"]').change(function(){
                    get_child_options();
                });
            </script>
    </body>
</html>