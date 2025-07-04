<div id="ticketModal" class="modal fade">
	<div class="modal-dialog">

		<form method="post" id="ticketForm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<?php if(isset($_SESSION["admin"])) { ?>
					<div class="form-group">
						<label for="name" class="control-label">Name</label>
						<!-- <input type="text" class="form-control" id="name" name="name" placeholder="Name" required> -->
						<select id="name" name="name" class="form-control" autocomplete="off" required>					
							<?php $tickets->getUsers(); ?>
						</select>	
					</div>
					<?php } else { ?>
					<div class="form-group"> 
						<input type="hidden" class="form-control" id="name" name="name" value="<?php echo $_SESSION["user_name"]; ?>" required>
					</div>
					<?php } ?>
					<div class="form-group">
						<label for="subjectName" class="control-label">Subject</label>
						<!-- <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required> -->
						<select id="subjectName" name="subjectName" class="form-control" placeholder="Subject...">					
							<?php $tickets->getSubjects(); ?>
						</select>	
					</div>

					<?php if($user['department'] == '0') { echo $ticket[$user['id']];?>

					<div class="form-group">
						<label for="departmentName" class="control-label">Division</label>			
							
							<!-- <select id="departmentName" name="departmentName" class="form-control" disabled>					
							</select>	
						
						?php } else { ?>		
							 -->
							<select id="departmentName" name="departmentName" class="form-control">		
								<?php $tickets->getDepartments(); ?>
							</select>	
						
					</div>		

					<?php } else { ?>
							<input type="hidden" id="departmentName" name="departmentName" value="<?php echo $user['department']; ?>"/>
					<?php } ?>

					<div class="form-group">
						<label for="message" class="control-label">Message</label>							
						<textarea class="form-control" rows="5" id="message" name="message"></textarea>							
					</div>	
					<div class="form-group">
						<label for="open" class="control-label">Status</label>							
						<label class="radio-inline">
							<input type="radio" name="status" id="open" value="0" checked required>Open
						</label>
						<?php if(isset($_SESSION["admin"])) { ?>
							<label class="radio-inline">
								<input type="radio" name="status" id="close" value="1" required>Close
							</label>
						<?php } ?>	
					</div>

					<!-- Urgency/Priority -->
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