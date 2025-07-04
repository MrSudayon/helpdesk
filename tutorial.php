<!--
Page changes for this feature:
introduction.php
menus.php
general.js
/assets/Helpdesk.png


js removed lines:
tickets.js
user.js


fixed bug on:
tickets.js
add_ticket_model.php
ticket.php 
subject.php
department.php
login.php
register.php
-->

<?php 
include 'init.php';

if(!$users->isLoggedIn()) {
	header("Location: login.php");	
}

<<<<<<< HEAD
=======
if (isset($_SESSION['LAST_ACTIVITY']) && 
    (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.php"); // redirect to login
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

>>>>>>> refs/remotes/origin/master
include('inc/header.php');
$user = $users->getUserInfo();
?>
	<title>Helpdesk</title>

	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>		
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
	<script src="js/general.js"></script>
	<script src="js/subject.js"></script>
	<!-- <script src="js/department.js"></script> -->
	<link rel="stylesheet" href="css/style.css"/>
<?php include('inc/container.php'); ?>

<div class="container">	
	<div class="row home-sections">
		<img src="assets/Logo.png" style="height: 30px; margin: 20px 0;"></img>
		<?php include('menus.php'); ?>		
	</div> 

    <div class="mainSubject">What is Microsoft 365 for Business?</div>
<<<<<<< HEAD
	<video width="80%" controls>
		<source src="assets/videos/Microsoft 365.mp4" type="video/mp4">
		<source src="assets/videos/Microsoft 365.mp4" type="video/ogg">
		Your browser does not support HTML video.
	</video>
	<p id="courtesy">Video courtesy of <a href="https://support.microsoft.com/en-US/microsoft-365" target="_blank">Microsoft 365</a>.</p>
	<!-- <br> -->
=======
	<div><div style="left: 0; width: 100%; height: 0; position: relative; padding-bottom: 56.25%;"><iframe src="https://cdn.iframe.ly/api/iframe?url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DjugBQqE_2sM%26list%3DPLXPr7gfUMmKxiPKpMocZRkA-AUDI9N1RB&key=925108d922be940af814f71907a7df4b" style="top: 0; left: 0; width: 100%; height: 100%; position: absolute; border: 0;" allowfullscreen scrolling="no" allow="accelerometer *; clipboard-write *; encrypted-media *; gyroscope *; picture-in-picture *; web-share *;"></iframe></div><a href="https://embedcodesgenerator.com/tools/youtube-embed-code?gad_source=1&gad_campaignid=22458335448&gbraid=0AAAAA_LxlSiub2yKPKBSZj56VKF4_Nnx2&gclid=Cj0KCQjw1JjDBhDjARIsABlM2Su-cv28vaHwtWxFFKR4mN1TeDWORcD67nKaFm7klwkGQY2_CIP3k6kaAur-EALw_wcB" rel="noopener" target="_blank" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">youtube embed code</a></div>
>>>>>>> refs/remotes/origin/master
	<p>With Microsoft 365 for business, connect employees to the people, information, and content they need to do their best work, from any device.</p>
	<p>Depending on your subscription plan, the benefits of your Microsoft 365 for business subscription may include:</p>
	<ul class="lists">
		<li>The latest versions of Office apps like Word, Excel, and PowerPoint.</li>
		<li>Email and calendars using Outlook and Exchange.</li>
		<li>Group chat, online meetings, and calling in Microsoft Teams.</li>
		<li>1 TB of OneDrive storage.</li>
		<li>Frequent updates and upgrades not available anywhere else.</li>
	</ul>
		





	<br><br>
	<div class="mainSubject">Get started with Microsoft Teams</div>
		<p>Microsoft Teams is a collaboration app built for hybrid work so you and your team stay informed, organized, and connected — all in one place.</p>
<<<<<<< HEAD
	<video width="80%" controls>
		<source src="assets/videos/TeamsBasics.mp4" type="video/mp4">
		<source src="assets/videos/TeamsBasics.mp4" type="video/ogg">
=======
	<video width="80%" preload="auto" controls>
		<source src="assets/videos/TeamsBasics.mp4" type="video/mp4">
>>>>>>> refs/remotes/origin/master
		Your browser does not support HTML video.
	</video>
	<p id="courtesy">Video courtesy of <a href="https://support.microsoft.com/en-US/microsoft-365" target="_blank">Microsoft 365</a>.</p>

	<p>Explore how Teams can help you and your colleagues come together no matter where you are:</p>
	<ul class="lists">
		<li><b>Chat</b> - Message someone or a group to talk about work, projects, or just for fun.</li>
		<li><b>Teams</b> - Create a team and channels to gather people together and work in focused spaces with conversations and files.</li>
		<li><b>Calendar</b> - Connect with people before, during, and after a meeting so prep and follow-up are easy to find. This Teams calendar syncs with your Outlook one.</li>
		<li><b>Apps</b> - Find familiar apps and explore new ones to simplify, customize, and manage how you work.</li>
	</ul>
	<h3>Tips</h3>
	<ul>
		<li>Catch up on all your unread messages, @mentions, replies, and more under <b>Activity.</b></li>
		<li>Use the <b>Search</b> box to find and filter specific items or people, take quick actions, and launch apps.</li>
	</ul>
	<br>



	<br>
	<div class="mainSubject">Copilot in Teams</div>
		<p>Copilot in Microsoft Teams enhances collaboration and helps you get the most out of your Teams chats and meetings. Quickly recap, identify follow-up tasks, create agendas, and ask questions for more effective and focused meetings. Summarize key takeaways, see what you’ve missed, and pinpoint key people of interest in chat threads you were added to. All without breaking the flow of discussion. </p>
	<video width="80%" controls>
		<source src="assets/videos/Catchup_on_meetings.mp4" type="video/mp4">
		<source src="assets/videos/Catchup_on_meetings.mp4" type="video/ogg">
		Your browser does not support HTML video.
	</video>
	<p id="courtesy">Video courtesy of <a href="https://support.microsoft.com/en-US/microsoft-365" target="_blank">Microsoft 365</a>.</p>

	<p>Copilot works alongside you to bring together data from your documents, presentations, email, calendar, notes, and contacts in Microsoft Teams. Find and use info that's buried in documents or lost in conversations, and get things done in whole new ways using the power of AI.</p>
	<ol class="lists">
		<li>Go to <b>Chat</b> on the left side of Teams.</li>
		<li>Select <b>Copilot</b> from the top of your Teams chat list.</li>
		<li>In the Copilot chat, type your prompt. For example, "Summarize my recent unread messages from [a person]."</li>
		<li>Select <b>Send</b>.</li>
		<li>Once Copilot generates a response, select the sources to understand how the response was cited. AI-generated content may be incorrect, so sources are provided for your review when possible.</li>
	</ol>

	<div class="subject">Requirements for Copilot in meetings</div> 
	<ul class="lists">
		<li>Turn on transcription or recording. To use Copilot without recording or transcription, see Use Copilot without recording. All participants see a notification that the meeting is being transcribed.</li>
		<li>Have enough meeting time where participants have been speaking. If there isn’t enough transcribed speech in the meeting yet, Copilot will state that it needs more information before responding to prompts.</li>
		<li>Ensure the meeting was created by someone within your organization. If a meeting was created by an external participant, Copilot won’t be available in that meeting. If external participants are invited but not the meeting organizer, Copilot will still be available in the meeting.</li>
	</ul>
	<br>
	<p id="courtesy">Find out more at <a href="https://support.microsoft.com/en-us/office/welcome-to-copilot-in-microsoft-teams-725be278-ffce-4e22-90e8-0a6ef95bf4a2" target="_blank">Copilot in Microsoft Teams</a></p>








	<br><br>
	<div class="mainSubject">OneDrive video tutorials</div>
		<p>Explore a range of helpful video tutorials to make the most of OneDrive's powerful features. Whether you're working on desktop or mobile, these videos provide essential tips to optimize your OneDrive experience across all platforms.</p>
		<br>
	<div class="subject">For Web:</div>
	<p>Access, manage, and share your files directly from your browser with the OneDrive for Web tutorial, perfect for on-the-go users.</p>
<<<<<<< HEAD
	<video width="80%" controls>
=======
	<video width="80%" preload="auto" controls>
>>>>>>> refs/remotes/origin/master
		<source src="assets/videos/OneDriveforweb.mp4" type="video/mp4">
		<source src="assets/videos/OneDriveforweb.mp4" type="video/ogg">
		Your browser does not support HTML video.
	</video>
	<p id="courtesy">Video courtesy of <a href="https://support.microsoft.com/en-US/microsoft-365" target="_blank">Microsoft 365</a>.</p>

	<br><br>
	<div class="subject">For Windows:</div>
		<p>Discover how OneDrive integrates with Windows to keep your files backed up, synced, and accessible from any device.</p>
	<video width="80%" controls>
		<source src="assets/videos/OneDriveforWindows.mp4" type="video/mp4">
		<source src="assets/videos/OneDriveforWindows.mp4" type="video/ogg">
		Your browser does not support HTML video.
	</video>
	<p id="courtesy">Video courtesy of <a href="https://support.microsoft.com/en-US/microsoft-365" target="_blank">Microsoft 365</a>.</p>

	<br><br>
	<div class="subject">For Mac:</div>
	<p>Learn how to easily share files and collaborate with others in real time to enhance your team’s productivity.</p>
	<video width="80%" controls>
		<source src="assets/videos/OneDriveforMac.mp4" type="video/mp4">
		<source src="assets/videos/OneDriveforMac.mp4" type="video/ogg">
		Your browser does not support HTML video.
	</video>
	<p id="courtesy">Video courtesy of <a href="https://support.microsoft.com/en-US/microsoft-365" target="_blank">Microsoft 365</a>.</p>



</div>	
<?php include('inc/footer.php');?>