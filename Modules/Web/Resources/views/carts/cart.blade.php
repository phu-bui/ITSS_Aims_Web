@extends('web::layouts.master')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="table-responsive cart_info" id="list-cart">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Cash</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @if(Session::has("Cart") != null)
                    @foreach(Session::get('Cart')->products as $product)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img width="60" src="{{$product['productInfo']->image}}" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h5><a href="">{{$product['productInfo']->title}}</a></h5>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($product['productInfo']->price)}} VND</p>
                        </td>
                        <td class="cart_quantity">
                            <!-- <div class="cart_quantity_button">
                                <a class="cart_quantity_up" > + </a>
                                <a href="">{{$product['quanty']}}</a>
                                <a class="cart_quantity_down" > - </a>
                            </div> -->
                            <div class="buttons_added">
  								<a onclick="DeleteOne({{$product['productInfo']->productId}})"><input class="minus is-form" type="button" value="-"></a>
  								<input aria-label="quantity" class="input-qty" max="10" min="1" name="" type="number" value="{{$product['quanty']}}">
  								<a onclick="AddCart({{$product['productInfo']->productId}})" href="javascript:"><input class="plus is-form" type="button" value="+"></a>
							</div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{number_format($product['price'])}} VND</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" onclick ="DeleteItemCart({{$product['productInfo']->productId}})">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="cart_total">
                            <p class="cart_total_price">Total : {{number_format(Session::get('Cart')->totalPrice)}} VND</p>
                        </td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->

 <script src="{{asset('frontend/js/jquery-3.2.1.min.js')}}"></script>
@if(Session::has("Cart") != null)
<script>
$('input.input-qty').each(function() {
  var $this = $({{$product['quanty']}}),
    qty = $this.parent().find('.is-form'),
    min = Number($this.attr('min')),
    max = Number($this.attr('max'))
  if (min == 0) {
    var d = 0
  } else d = min
  $(qty).on('click', function() {
    if ($(this).hasClass('minus')) {
      if (d > min) d += -1
    } else if ($(this).hasClass('plus')) {
      var x = Number($this.val()) + 1
      if (x <= max) d += 1
    }
    $this.attr('value', d).val(d)
  })
})
</script>

<script>

	function DeleteOne(id){
		console.log(id);
        // let link = '{{route('web.delete_one', ':id')}}'
        // link = link.replace(':id', id)
        // $.ajax({
        //     url: link,
        //     type: 'GET',
        // }).done(function(response){
        // 	RenderListCart(response);
        //     alertify.success('Add to cart successful!');
        // });
        $.ajax({
            url: '/Delete-One/'+id,
            type: 'GET',
        }).done(function(response){
            RenderListCart(response);
           alertify.success('Xoa thanh cong');
        });
    }

	function AddCart(id){
        let link = '{{route('web.add_cart', ':id')}}'
        link = link.replace(':id', id)
        $.ajax({
            url: link,
            type: 'GET',
        }).done(function(response){
        	RenderListCart(response);
            alertify.success('Add to cart successful!');
        });
    }

    function DeleteItemCart(id){
        console.log(id);
        $.ajax({
            url: 'Delete-Item-Cart/'+id,
            type: 'GET',
        }).done(function(response){
            RenderListCart(response);
           alertify.success('Xoa thanh cong');
        });
    }

    function RenderListCart(response){
        $("#list-cart").empty();
        $("#list-cart").html(response);

    }
</script>
@endif
@endsection
