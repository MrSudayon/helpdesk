<div id="purchaseModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="purchaseForm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<div class="title">Details</div>
					<div class="asset-details">
						<div class="input-box" style="width: 100%;">
							<!-- <label for="company" class="control-label">Company</label>		 -->
							<span class="details">Company</span>  					
							<select id="company" name="company" placeholder="Company...">					
								<?php $purchase->getCompany(); ?> 
							</select>	
						</div>

						<div class="input-box">
							<span class="details">Requested by</span>  											
							<input type="text" name="requestedby" id="requestedby" value="<?php echo $user['name']; ?>" style="background-color: #ccc;" readonly/>	 
						</div>

						<div class="input-box">
							<span class="details">Department</span>  					
							<select id="department" name="department" placeholder="Company...">	
								<?php $purchase->getDepartments(); ?> 
							</select>	
						</div>

						<div class="input-box">
							<span class="details">Endorsed by</span>  					
							<input type="text" name="endorsedby" id="endorsedby" placeholder="Endorsed by..." value=""/>	 
						</div>

						<div class="input-box">
							<span class="details">Date</span>  					
							<input type="date" name="date" id="date" value=""/>	 
						</div>

						<div class="input-box">
							<span class="details">Email</span>  					
							<input type="email" name="email" id="email" placeholder="Optional" value=""/>	 
						</div>

						<div class="input-box">
							<span class="details">Subject</span>  					
							<input type="text" name="subject" id="subject" placeholder="Purpose..." value=""/>	 
						</div>
					</div>

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
							<input type="text" name="amount" id="amount" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Terms</span>  					
							<input type="text" name="terms" id="terms" placeholder="no. of days" value=""/>
						</div>
						<div class="input-box">
							<span class="details">PDC Date</span>  					
							<input type="date" name="pdcdate" id="pdcdate"value=""/>
						</div>
					</div>

					<div class="title">Request Form</div>
					<button id="addRequestForm" class="btn btn-primary" style="width: 100%;">+ Add form</button>
					<div class="form" id="requestform">
					<div class="asset-details">
						<div class="input-box">
							<span class="details">Category</span>  	
							<input type="text" name="category[]" id="category" value=""/>
						</div>
						<div class="input-box">
							<span class="details">asd</span>  	
							<input type="text" name="asd" id="asd" value=""/>
						</div>
					</div>
							
						<!-- <div class="input-box">
							<span class="details">Account Name</span>  	
							<input type="text" name="accname" id="accname" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Quantity</span>  	
							<input type="number" name="quantity" id="quantity" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Brand</span>  	
							<input type="number" name="brand" id="brand" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Size</span>  	
							<input type="number" name="size" id="size" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Color</span>  	
							<input type="number" name="color" id="color" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Other Description</span>  	
							<input type="number" name="description" id="description" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Amount</span>  	
							<input type="number" name="amount" id="amount" value=""/>
						</div>
						<div class="input-box">
							<span class="details">Supplier</span>  	
							<input type="number" name="supplier" id="supplier" value=""/>
						</div>
					</div> -->
				</div>
				<div class="modal-footer">
					<input type="hidden" name="ticketId" id="ticketId" />
					<input type="hidden" name="action" id="action" value="" />
					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>