<div id="purchaseModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="purchaseForm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Purchase Request</h4>
				</div>
				<div class="modal-body">
                    <div class="form-group"
						<label for="requestedby" class="control-label">Requested by:</label>
						<input type="text" class="form-control" id="requestedby" name="requestedby" placeholder="Requested by" required>			
					</div>
                    <div class="form-group"
						<label for="department" class="control-label">Department</label>
						<input type="text" class="form-control" id="department" name="department" placeholder="Department..." required>			
					</div>
					<!-- <div class="form-group">
						<label for="department" class="control-label">Department</label>							
						<select id="department" name="department" class="form-control" placeholder="Department...">					
							 $tickets->getDepartments(); 
						</select>						
					</div>		 -->
                    <div class="form-group"
						<label for="endorsedby" class="control-label">Endorsed by:</label>
						<input type="text" class="form-control" id="endorsedby" name="endorsedby" placeholder="Endorsed by" required>			
					</div>
                    <div class="form-group"
						<label for="subject" class="control-label">Subject</label>
						<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>			
					</div>
					<div class="form-group">
						<label for="message" class="control-label">Message</label>							
						<textarea class="form-control" rows="5" id="message" name="message"></textarea>							
					</div>	
					<div class="form-group">
						<label for="status" class="control-label">Status</label>							
						<label class="radio-inline">
							<input type="radio" name="status" id="open" value="0" checked required>Open
						</label>
						<?php if(isset($_SESSION["admin"])) { ?>
							<label class="radio-inline">
								<input type="radio" name="status" id="close" value="1" required>Close
							</label>
						<?php } ?>	
					</div>
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