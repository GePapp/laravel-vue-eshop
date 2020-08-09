$('.btn-add').click(function(e) {
  var price = 'Preis: ' + $(this).data('price');
  var title = $(this).data('title');
  var id = $(this).data('id');
  var url = 'http://127.0.0.1:8000/pages/shop/addToCart/'+id;

  $('#myModal').find("#title").append(title);
  $('#myModal').find("#price").append(price);
  $('#myModal').modal('show');

  setTimeout(function(){
    $('#myModal').modal('hide')
  }, 2000);
  setTimeout(function(){ window.location.href = url }, 2000);
 });
