<div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <div class="info-box-content">
                                <span class="info-box-text">Total product</span>
                                <span class="info-box-number">{{count($products)}}</span>
                            </div>
                        </h5>
                        <div class="input-group mt-3 mb-3">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                    Category
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($categories as $category)
                                        <a class="dropdown-item" href="{{route('admin.category_home', array('cate_name'=>$category->categoryName))}}">{{$category->categoryName}}</a>
   
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="mb-0 table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Value</th>
                                        <th>Quantity</th>
                                        <th>Update/Delete</th>
                                        <th>
                                            <div id="conditional_part">
                                                <button class="mb-2 btn btn-outline-success" id="delete-all" >Delete all</button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $index => $product)
                                    <tr>
                                        <th scope="row">{{$index + 1}}</th>
                                        <td><img width="60" class="" src="{{$product->image}}" alt=""></td>
                                        <td>{{$product->title}}</td>
                                        <td>{{($product->price)}}</td>
                                        <td>{{($product->value)}}</td>
                                        <td>
                                            @if($product->quantity > 0)
                                                <div class="mb-2 mr-2 badge badge-success">Stocking</div>
                                            @else
                                                <div class="mb-2 mr-2 badge badge-danger">Out of stock</div>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{route('admin.delete_product', array('product_id'=>$product->productId))}}">
                                                <button class="mb-2 mr-2 btn-transition btn btn-outline-success" onclick="return confirm('Are you sure you want to delete this product?')" >Delete</button>
                                            </form>
                                            <form action="{{route('admin.edit_product', array('product_id'=>$product->productId))}}"><button class="mb-2 mr-2 btn-transition btn btn-outline-primary">Detail</button></form>
                                        </td>
                                        <td><input type="checkbox" name="product_name" value="{{$product->productId}}"  id="fluency"></td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-block text-center card-footer">
                        {{$products->links()}}
                    </div>
                </div>