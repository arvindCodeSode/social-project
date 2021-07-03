<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "classes/$class.php";
}
require_once 'user/ip.php';
$activity=new text_activity();
$blogs=new blogs($activity);
$share=new share($activity);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once 'link.php'; ?>
	<title>ViVinam: About Us</title>
	<style type="text/css">
		body{
			font-family: arial, Helvetica, sans-serif;
			margin: 0;
			width: 100%;
			min-width: 100%;
			background-color: #deade2;
		}
		html{box-sizing: border-box;font-size: 1em;width: 100%;}
		h1{font-size: 1.5em;}
		.cookie{
			font-size: 0.5em;
		}
		@media screen and (min-width: 210px){
			.cookie{font-size: 0.6em;}
		}
		@media screen and (min-width: 250px){
			.cookie{font-size: 0.7em;}
		}
		@media screen and (min-width: 300px){
			.cookie{font-size: 0.8em;}
		}
		@media screen and (min-width: 400px){
			.cookie{font-size: 1em;}
		}
			@media screen and (min-width: 700px){
			.cookie{font-size: initial;}
		}
	</style>
</head>
<body>
<?php require_once 'topn.php'; ?>
<div class="cookie">
	<div>
	<h1>About Cookies Policy at vivinam.com</h1>
	<h2>What is Cookie</h2>
	<p>A cookie is a small file containing an identifier (a string of letters and numbers) that is sent by a web server to a web browser and is stored by the browser. The identifier is then sent back to the server each time the browser requests a page from the server. Cookies can be used by web servers to identity and track users as they navigate different pages on a website and identify users returning to a website. Cookies do not typically contain any information that personally identifies a user, but personal information that we store about you may be linked to the information stored in and obtained from cookies.</p>

	<p>If you use the Tutorials Point, both Tutorials Point and third parties will use cookies to track and monitor some of your activities on and off the Tutorials Point website, and store and access some data about you, your browsing history, and your usage of the tutorialspoint.com website.</p>
	<p>We use both session cookies, which expire after a short time or when you close your browser, and persistent cookies, which remain stored in your browser for a set period of time. We use session cookies to identify you during a single browsing session, like when you log into Tutorials Point. We use persistent cookies where we need to identify you over a longer period, like when you request that we keep you signed in.</p>

	<p>This policy describes how both Tutorials Point and other third parties use cookies both within and without the Tutorials Point Website and how you can exercise a greater degree of control over cookies. Please keep in mind that this may alter your experience with our platform, and may limit certain features (including being logged in as a user).</p>
	</div>
	<div>
	<h2>Why do we use Cookies</h2>
	<p>Kindly be informed that our website uses cookies to enhance our services based on user preferences. We use cookies and similar technologies like web beacons, pixel tags, or local shared objects (“flash cookies”), to deliver, measure, and improve our services in various ways.</p>
	<p>We use these cookies both when you visit our site and services through a browser and through our mobile app. As we adopt additional technologies, we may also gather additional data through other methods.</p>
	</div>
	<div>
	<p>We use cookies for the following purposes:</p>
	<ul>
		<li><p>Validate the authenticity of persons attempting to gain access to a specific user account.</p></li>
		<li><p>Enable behavior in our Products and/or Services that is tailored to the activity or preferences of a person visiting different sections of the website</p></li>
		<li><p>Allow users to opt out of certain types of modeling, tailoring, or personalization in our products.</p></li>
		<li><p>Provide and administer the Services, including to display customized content and facilitate communication with other users.</p></li>
		<li><p>Maintain the regular business operations of our Advertising and Marketing departments</p></li>
		<Li><p>Help to diagnose and correct downtime, bugs, and errors in our code to ensure that our products are operating efficiently.</p></li>
		<li><p>Identify individual users to attribute different activities while using various parts of the site.</p></li>
		<Li><p>To remember data about your browser and your preferences.</p></li>
		<li><p>To remember your settings and other choices you’ve made at our website.</p></li>
	</ul>
	</div>
	<div>
	<h2>Google Analytics</h2>
	<p>Our adverting agencies/partners like google also collect cookies to show various contextual ads on our website.</p>
	<p>Google Analytics is Google’s powerful and widely used traffic analytics tool that allows website owners to get deep and real time insight into how their site is being used, how much, and by whom.</p>
	<p>Tutorials Point uses Google Analytics to measure site traffic, visitor behavior, and to improve delivery of services. To understand the information shared with Google, how it is processed, and how you can control the information collected by Google on vivinam.com, visit https://policies.google.com/technologies/partner-sites</p>
	<p>In addition to personal information, certain anonymous information about your visit is automatically captured when you visit the Site. This information includes the name of the Internet service provider and the Internet Protocol (IP) address through which you access the Internet; the date and time you access the Site; the pages that you access while at the Site, occasional geographic data, and the Internet address of the Web site from which you linked directly to our site. We also may use your IP address to determine the organization that you are affiliated with. This anonymous information is used to help improve the Site, analyze trends, and administer the Site.</p>
	</div>
	<div>
	<h2>What Information we Collect</h2>
	<p>We collect certain data from you directly, like information you enter yourself, data about your participation in courses, and data from third-party platforms you connect with Tutorials Point. We also collect some data automatically, like information about your device and what parts of our Services you interact with or spend time using.</p>
	<p>In addition to personal information, certain anonymous information about your visit is automatically captured when you visit the Site. This information includes the name of the Internet service provider and the Internet Protocol (IP) address through which you access the Internet; the date and time you access the Site; the pages that you access while at the Site, occasional geographic data, and the Internet address of the Web site from which you linked directly to our site. We also may use your IP address to determine the organization that you are affiliated with. This anonymous information is used to help improve the Site, analyze trends, and administer the Site.</p>

	<p>We may monitor your interactions with the Site, such as what pages you visit, what content you review, and what comments you make, and maintain this information with your Site profile.</p>
	</div>
	<div>
	<h2>What are my privacy options?</h2>
	<p>Most browsers automatically accept cookies, but you can change your browser settings to decline cookies by consulting your browser’s support articles. If you decide to decline cookies, please note that you may not be able to sign in, customize, or use some interactive features in the Services.</p>
	<p>To opt out of Google Analytics’ display advertising or customize Google Display Network ads, visit the <a href="https://adssettings.google.com/authenticated" rel="nofollow" traget="_blank">Google Ads Settings page</a>.</p>
	<p>For general information about targeting cookies and how to disable them, visit www.allaboutcookies.org.</p>
	</div>
	<div>
	<h2>Updates & Contact Info</h2>
	<p>From time to time, we may update this Cookie Policy. If we do, we’ll notify you by posting the policy on our site with a new effective date. If we make any material changes, we’ll take reasonable steps to notify you in advance of the planned change.</p>
	<p>If you have any questions about our use of cookies, please email us at <a href="contact.php">contact</a></p>

	<p>This Cookie Policy was last updated on Feb 02, 2019</p>
	</div>
</div>
<?php
require_once 'footer.php';
?>
</body>
</html>