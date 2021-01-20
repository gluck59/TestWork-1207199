<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plan</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<style>
    .ourItem { cursor: pointer; }
</style>
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6">
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">Let's plan your Purchases
                        <button class="pull-right btn btn-success btn-xs" data-toggle="modal" data-target="#myModal" id="addNew"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </h3>
				  </div>
<?php
//echo '<pre>';
//print_r($items);
//echo '</pre>';
?>
				  <div class="panel-body" id="items">
				    @if(count($items)>0)
                        <ul class="list-group">
                            @foreach($items as $item)
                                <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">
                                    {{$item->item}}
                                    <input type="hidden" id="itemId" value="{{$item->id}}">
                                    <br />
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No purchases found. Press plus button and add new.</p>
                    @endif    
				  </div>
				</div>
			</div>

            <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document"><!-- modal-dialog -->
                    <div class="modal-content"><!-- modal-content -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="title">Add new purchase</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id">
                            <p><input type="text" id="addItem" placeholder="type a item name" class="form-control"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="display:none;" id="delete">Delete</button>
                            <button type="button" class="btn btn-primary" style="display:none;" data-dismiss="modal" id="update">Update</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal" id="add">Add item</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div>
            </div>
        </div>
    </div>

    {{ csrf_field() }}

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>    

    <script>
        $(document).ready(function(){
            $(document).on('click', '.ourItem', function(event) {
                var text = $(this).text();
                var id = $(this).find('#itemId').val();
                $('#title').text('Edit item');
                var text = $.trim(text);
                $('#add').hide();
                $('#delete').show();
                $('#update').show();
                $('#addItem').val(text);
                $('#id').val(id);
            });

            $(document).on('click', '#addNew', function(event) {
                $('#title').text('Add new purchase');
                $('#add').show();
                $('#delete').hide();
                $('#update').hide();
                $('#addItem').val("");
            });

            $('#add').click(function(){
                var text = $('#addItem').val();
                if(text == "") {
                    alert('please type anything for item');
                    return false;
                } else { 
                    $.post('create', {'text': text,'_token':$('input[name=_token]').val()}, function(data) {
                        //console.log(data);
                        $('#items').load(location.href + ' #items')
                    });
                }
            });

            $('#delete').click(function(e){
                //console.log($('#addItem').val())
                var x = confirm("Delete "+$('#addItem').val()+"?");
                if(x) {
                    var id = $("#id").val();
                    $.post('delete', {'id': id,'_token':$('input[name=_token]').val()}, function(data) {
                        $('#items').load(location.href + ' #items');
                        // console.log(data);
                    });
                }        
            }); 

            $('#update').click(function(){
                var id = $("#id").val();
                var value = $('#addItem').val();
                
                if(value == "") {
                    alert('Please type anything');
                } else { 
                    $.post('update', {'id': id, 'value' : value,'_token':$('input[name=_token]').val()}, function(data) {
                        $('#items').load(location.href + ' #items');
                        // console.log(data);
                    });
                }    
            });

        });
    </script>
</body>
</html>
