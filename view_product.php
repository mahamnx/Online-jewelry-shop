<?php
include 'admin/db_connect.php';
$qry = $conn->query("SELECT p.*, c.name as cname,c.description as cdesc FROM products p inner join categories c on c.id = p.category_id where p.item_code = '{$_GET['c']}' ")->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'ftitle';
	$$k = $v;
}
$img = array();
if(isset($item_code) && !empty($item_code)):
            if(is_dir('assets/uploads/products/'.$item_code)):
                $_fs = scandir('assets/uploads/products/'.$item_code);
              foreach($_fs as $k => $v):
	                if(is_file('assets/uploads/products/'.$item_code.'/'.$v) && !in_array($v,array('.','..'))):
	                	$img[] = 'assets/uploads/products/'.$item_code.'/'.$v;
					endif;
				endforeach;
			endif;
endif;
?>
<style>
   input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    #qty{
        width: 50px;
        text-align: center
    }
</style>
<div class="col-lg-12">
    <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none"><?php echo $name ?></h3>
              <div class="col-12">
                <img src="<?php echo isset($img[0]) ? $img[0] : '' ?>" class="product-image img-thumbnail" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
              	<?php 
          			foreach($img as $k => $v): 

  				?>
                <div class="product-image-thumb <?php echo $k == 0 ? 'active' : '' ?>"><img src="<?php echo $v ?>" alt="Product Image"></div>
            	<?php endforeach; ?>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3"><?php echo ucwords($name) ?></h3>
              <p>Category: <?php echo ucwords($cname) ?></p>

              <hr>
              <h4>Available Sizes</h4>
              <?php 
              $sizes = $conn->query("SELECT * FROM sizes where product_id = $id");
              $size_arr = array();
              while($row = $sizes->fetch_assoc()){
              	$size_arr[$row['id']] = $row['size'];
              }
              ?>
              <div class="form-group">
                <select name="size_id" id="size_id" class="custom-select">
                  <?php if(count($size_arr) == 0): ?>
                    <option value="0">N/A</option>
                  <?php else: ?>
                  <?php foreach($size_arr as $k => $v): ?>
                    <option value="<?php echo $k ?>"><?php echo $v ?></option>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>

               <h4>Available Colors</h4>
              <?php 
              $colours = $conn->query("SELECT * FROM colours where product_id = $id");
              $colour_arr = array();
              while($row = $colours->fetch_assoc()){
              	$colour_arr[$row['id']] = $row['color'];
              }
              ?>
              <div class="form-group">
                <select name="colour_id" id="colour_id" class="custom-select">
                  <?php if(count($colour_arr) == 0): ?>
                    <option value="0">N/A</option>
                  <?php else: ?>
                  <?php foreach($colour_arr as $k => $v): ?>
                    <option value="<?php echo $k ?>"><?php echo $v ?></option>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>

              <div class="bg-gray disabled py-2 px-3 mt-4">
                <h2 class="mb-0">
                  <?php echo number_format($price,2) ?>
                </h2>
                
              </div>

             <div class="mt-4 d-flex w-100">
                <div class="d-flex col-sm-5">
                    <span class="btn btn-primary btn-lg btn-flat btn-minus"><b><i class="fa fa-minus"></i></b></span>
                    <input type="number" name="qty" id="qty" value="1">
                    <span class="btn btn-primary btn-lg btn-flat btn-plus"><b><i class="fa fa-plus"></i></b></span>
                </div>
              <div class="btn btn-primary btn-lg btn-flat" id="add_to_cart">
                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                Add to Cart
              </div>

             <!--  <div class="btn btn-default btn-lg btn-flat">
                <i class="fas fa-heart fa-lg mr-2"></i>
                Add to Wishlist
              </div> -->
            </div>

              

            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-cat-desc" role="tab" aria-controls="product-cat-desc" aria-selected="false">Category Description</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"><?php echo html_entity_decode($description) ?></div>
              <div class="tab-pane fade" id="product-cat-desc" role="tabpanel" aria-labelledby="product-cat-desc-tab"> <?php echo html_entity_decode($cdesc) ?></div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
</div>
<script>
  $(document).ready(function(){
      $('.btn-minus').click(function(){
            var qty = $(this).siblings('input').val()
                qty = qty > 1 ? parseInt(qty) - 1 : 1;
                $(this).siblings('input').val(qty).trigger('change')
       })
      $('.btn-plus').click(function(){
        var qty = $(this).siblings('input').val()
            qty = parseInt(qty) + 1;
            $(this).siblings('input').val(qty).trigger('change')
     })
      $('#add_to_cart').click(function(){
        if('<?php echo !isset($_SESSION['login_id']) ?>' == 1){
                location.href='login.php'
                return false
        }
        start_load()

        $.ajax({
            url:'admin/ajax.php?action=add_to_cart',
            method:'POST',
            data:{product_id: '<?php echo $id ?>',price: '<?php echo $price ?>', qty:$('#qty').val(), colour_id:$('#colour_id').val(), size_id:$('#size_id').val()},
            success:function(resp){
                if(resp == 1){
                    alert_toast("Product successfully added to cart.","success")
                    end_load()
                    load_cart()
                }
            }
        })
    })  
  })
</script>