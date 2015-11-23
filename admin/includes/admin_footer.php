 </div>
            <footer class = "text-center" id="footer">&copy; Copyright 2015-2017 Umer's E-Commerce World</footer>	
            <script>
                function updateSizes(){
                    alert('updates sizes');
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