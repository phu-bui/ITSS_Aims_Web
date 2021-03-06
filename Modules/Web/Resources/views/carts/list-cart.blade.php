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
