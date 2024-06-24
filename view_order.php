<?php include 'admin/db_connect.php' ?>
<style type="text/css">
	.img-field{
		width: calc(25%);
		max-height: 25vh;
		overflow: hidden;
		display: flex;
		justify-content: center
	}
	.detail-field{
		width: calc(50%);
	}
	.amount-field{
		width: calc(25%);
		text-align:right;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.img-field img{
		max-width: 100%;
		max-height: 100%;
	}
	.qty-input{
		width: 75px;
		text-align: center; 
	}

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
</style>
<div class="col-lg-12">	
    <?php 
    $qry = $conn->query("SELECT o.*,p.item_code,p.name as pname FROM order_items o inner join products p on p.id = o.product_id where o.order_id ={$_GET['id']}");
    $total = 0;
    ?>
    <div class="row">
    <div class="col-md-8">
    	<?php if($qry->num_rows > 0): ?>
    		<ul class="list-group">
    			<?php 
    			while($row= $qry->fetch_array()):
    				$total += $row['qty']*$row['price'];
    				$size = $conn->query("SELECT * FROM sizes where id = {$row['size_id']}");
    				$size = $size->num_rows>0 ? $size->fetch_array()['size'] : 'N/A';
    				$colour = $conn->query("SELECT * FROM colours where id = {$row['colour_id']}");
    				$colour = $colour->num_rows>0 ? $colour->fetch_array()['color'] : 'N/A';
    				$img = array();
					if(isset($row['item_code']) && !empty($row['item_code'])):
			            if(is_dir('assets/uploads/products/'.$row['item_code'])):
			                $_fs = scandir('assets/uploads/products/'.$row['item_code']);
			              foreach($_fs as $k => $v):
				                if(is_file('assets/uploads/products/'.$row['item_code'].'/'.$v) && !in_array($v,array('.','..'))):
				                	$img[] = 'assets/uploads/products/'.$row['item_code'].'/'.$v;
								endif;
							endforeach;
						endif;
					endif;
    			?>
    			<li class="list-group-item" data-id="<?php echo $row['id'] ?>" data-price="<?php echo $row['price'] ?>">
    				<div class="d-flex w-100">
    					<div class="img-field mr-4 img-thumbnail rounded">
    						<img src="<?php echo isset($img[0]) ? $img[0] : '' ?>"  alt="" class="img-fluid rounded">
    					</div>
    					<div class="detail-field">
    						<p>Product Name: <b><?php echo $row['pname'] ?></b></p>
    						<p>Price: <b><?php echo number_format($row['price'],2) ?></b></p>
    						<p>Size: <b><?php echo $size ?></b></p>
                            <p>Color: <b><?php echo $colour ?></b></p>
    						<p>QTY: <b><?php echo number_format($row['qty']) ?></b></p>
    						
    					</div>
    					<div class="amount-field">
    						<b class="amount"><?php echo number_format($row['qty']*$row['price'],2) ?></b>
    					</div>
    				</div>
    			</li>
    		<?php endwhile; ?>
    		</ul>
    	<?php else: ?>
    		<center><b>No Item</b></center>
    	<?php endif; ?>
    </div>
    <div class="col-md-4">
    	<div class="card mb-4">
    		<div class="card-header bg-primary text-white"><b>Total Amount</b></div>
    		<div class="card-body">
    			<h4 class="text-right"><b id="tamount"><?php echo number_format($total,2) ?></b></h4>
    		</div>
    	</div>
    </div>
</div>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
    #uni_modal .modal-footer{
        display: none
    }
    #uni_modal .modal-footer.display{
        display: flex
    }
</style>
<script>
</script>
