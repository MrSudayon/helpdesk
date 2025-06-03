<div id="purchaseModal" class="modal fade">
	<div class="modal-dialog">
		
		<form method="post" id="purchaseForm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<!-- <div class="form-group">
						<label for="subject" class="control-label">Company</label>
							<select id="company" name="company" placeholder="Company..." required>					
							</select>	
					</div> -->

					<div class="form-group">
						<label for="company" class="control-label">Company</label>							
						<select id="company" name="company" class="form-control">					
							<?php $purchase->getCompany(); ?> 
						</select>						
					</div>	

					<div class="form-group">
						<label for="department" class="control-label">Division</label>							
						<select id="department" name="department" class="form-control">					
							<?php $tickets->getDepartments(); ?>
						</select>						
					</div>			

					<div class="form-group">
						<label for="endorsedby" class="control-label">Endorsed by</label>					
						<select id="endorsedby" name="endorsedby" class="form-control">	
							<?php $purchase->getAdminUsers(); ?> 
						</select>	
					</div>

					<div class="form-group">
						<label for="subject" class="control-label">Subject</label>  					
							<input type="text" name="subject" id="subject" class="form-control"/>	 
					</div>

					<div class="form-group">
						<label for="date" class="control-label">Date</span>  					
							<input type="date" name="date" id="date" class="form-control"/>	 
					</div>
					<!-- <div class="form-group">
						<label for="message" class="control-label">Message</label>							
						<textarea class="form-control" rows="5" id="message" name="message"></textarea>							
					</div>	 -->
					<!-- <div class="form-group">
						<label for="status" class="control-label">Status</label>							
						<label class="radio-inline">
							<input type="radio" name="status" id="open" value="0" checked required>Open
						</label>
						<php if(isset($_SESSION["admin"])) { ?>
							<label class="radio-inline">
								<input type="radio" name="status" id="close" value="1" required>Close
							</label>
						<php } ?>	
					</div> -->

					<div class="title">Form of payment</div>
					<div class="asset-details">
						<div class="input-box" style="width: 100%;">
							<span class="details"></span>  
							<input type="radio" name="payment" id="cash" value="Cash" style="height: 10px; width: auto;">	 
							<label for="cash"> Cash </label>
							<input type="radio" name="payment" id="debit" value="Auto-debit" style="height: 10px; width: auto;">	 
							<label for="debit"> Auto-debit </label>
							<input type="radio" name="payment" id="cheque" value="Cheque" style="height: 10px; width: auto;">	 
							<label for="cheque"> Cheque </label>
						</div>

						<div class="input-box">
							<span class="details" style="width: 100%;">Cheque payee</span>  					
							<input type="text" name="cheqpayee" id="cheqpayee" value=""/>	 
						</div>
						<div class="input-box">	
							<span class="details">Date needed</span>  					
							<input type="date" name="dateneeded" id="dateneeded" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Amount</span>  					
							<input type="text" name="amount" id="amount" value="" required/>
						</div>
					</div>
					<!-- 
					<div class="title">Request Form</div>
					<button id="addRequestForm" class="btn btn-primary" style="width: 100%;">+ Add form</button>
					
					<div class="asset-details" class="form" id="requestform">
						<div class="input-box">
							<span class="details">Category</span>  	
							<input type="text" name="category[]" id="category" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Account name</span>  	
							<input type="text" name="accountName[]" id="accountName" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Quantity</span>  	
							<input type="text" name="qty[]" id="qty" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Brand</span>  	
							<input type="text" name="brand[]" id="brand" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Size</span>  	
							<input type="text" name="size[]" id="size" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Color</span>  	
							<input type="text" name="color[]" id="color" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Description</span>  	
							<input type="text" name="desc[]" id="desc" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Amount</span>  	
							<input type="text" name="amount[]" id="amount" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Supplier</span>  	
							<input type="text" name="supplier[]" id="supplier" value=""/>
						</div>
					</div>
					<a data-dismiss="purchaseModal modal" id="deleteRequestForm" class="btn btn-warning" style="width: 100%;" data-toggle="purchaseModal" href="#requestform">- Remove</a>

					<div class="title"></div> -->
				</div>
				<div class="modal-footer">
					<input type="hidden" name="requestId" id="requestId" />
					<input type="hidden" name="action1" id="action" value="" />
					<input type="submit" name="save1" id="save" class="btn btn-info" value="Save" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>