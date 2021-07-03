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
	<title>ViVinam: Term AND Condition</title>
  <?php require_once 'link.php'; ?>
	<style type="text/css">
		body{font-family: arial, Helvetica, sans-serif;margin: 0;width: 100%;min-width: 100%;background-color: #deade2;}
		html{box-sizing: border-box;font-size: 1em;width: 100%;}
		h1{font-size: 1.5em;}
		.cookie{
			font-size: 0.5em;
			padding: 10px;
			background-color: #434544;
			color: #f1f1f1;
		}
		.cookie p{margin: 5px 0;}
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
			h1{font-size: 2em;}
		}
	</style>
</head>
<body>
<?php require_once 'topn.php'; ?>
<div class="cookie">
	<h1>About Privacy Policy at vivinam.com</h1>
<p>The website <b>www.vivinam.com</b> is owned and maintained by <b>vivinam </b>, henceforth termed as “we”, “our”, “us”, or the “company”. All the visitors, users, learners, contributors, teachers, and instructors are named as "users"; and the website www.vivinam.com is termed as "website" everywhere in this document.</p>
<p>We are committed to protecting your privacy online. This privacy policy explains what information we collect from you or what information you share with us when you visit the website. We review our policy from time to time, so you are advised to check the latest version.</p>
<p>As a user of www.vivinam.com, you must agree to have read our privacy policy before sharing any information with us. This Privacy Policy is incorporated into and subject to the Terms of Use.</p>
<h2>Information we collect</h2>
<p>The visitors are free to navigate through our website without providing any personally identifiable information if they do not want to register with us.</p>
<p>To gain access to some of our products and services, you need to register with us and obtain an account, user name, and password. If you choose to register with us, and are 18 years of age or older, we will collect your personally identifiable information such as your name, email address, and phone number. We do not collect more information than is absolutely necessary to allow your participation in an activity on the website.</p>
<p>We collect and analyze information about your general usage of the website, products, services, and courses. We might track your usage patterns to see what features of the website you commonly use, website traffic volume, frequency of visits, type and time of transactions, type of browser, browser language, IP address and operating system, and statistical information about how you use our products and services. We only collect, track and analyze such information in an aggregate manner that does not personally identify you. Read the section on Use on Cookies to know how we collect aggregate data.</p>
<h2>How do we use your information?</h2>
<p>We do not sell your personal information to others. The personally identifiable Information you submit to receive information and services from our website will never be disclosed to any third party. We use this personally identifiable information to register you to access our services and verify your authority to access the courses and services.</p>
<p>We use the collected information to improve our website and to send you relevant information about our products and services which we think may be of interest to you. If you have subscribed for a service on our website, then your personally identifiable information may be used to enable us to serve you better.</p>
<p>We use the collected website information such as your usage patterns and how you access and use our products and services to help us improve our offerings and assist us in operating the website better.</p>
<p>When you enroll in a course, we might share your personally identifiable information with instructors as part of the course information to help them provide the course to you.</p>
<p>If you have enrolled for a course, we may seek your opinion and views in terms of testimonials to display on our website or in our social media channels. Unless you have informed us that you do not wish to receive further information about our products and services, we may send you direct promotional mails regarding our products and services. In case you don’t want us to feature your testimonials or don’t want to receive further information about our products or services, please notify us</p>
<h2>Interactive material</h2>
<p>There are portions of this website that may allow users to post their own material. As a user of this website, you agree that we do not necessarily endorse the views posted on our forums. By posting materials on this website, you represent that you have all necessary rights in and to such materials and that such materials will not infringe any personal or proprietary rights of any third parties.</p>
<p>We reserve the right to review or edit any material posted by users which we deem defamatory, unlawful, threatening, obscene or otherwise objectionable.</p>
<p>Apart from your account-related information such as account ID, password, and payment-related details, any other information that you post on the website through our forums or during a course are treated as non-confidential and the same can be distributed or reproduced without seeking further permission.</p>
<h2>Children's privacy</h2>
<p>We are committed to protecting children's privacy online. This website is intended for users above the age of 13. We do not knowingly collect information from children. We do not send unsolicited direct email to users who have indicated on registering of those pages that they are under 13. Children under 13 should ask a parent, guardian or teacher for permission before sending us information online.</p>
<h2>Billing</h2>
<p>If you as a registered user of our website use or provide services, for example, as an instructor, for which we implement a billing system for you, we will collect additional information from you so that we can process your payments. For example, we may collect your mailing address to remit payments.</p>
<p>Please be informed that the information you supply while making a payment for an availed service is processed through a secure payment gateway and that we do not store such information, including your bank account details, in our server.</p>
<h2>Links to other websites</h2>
<p>Our website contains links to other websites. The users need to take notice of the fact that the linked websites are governed by their own privacy policies and we disclaim any responsibility arising out of your actions on the linked website. We advise users to go through the privacy policy of the linked website and their terms and conditions before sharing any information to these websites.</p>
<h2>Disclosure of information</h2>
<p>We reserve the right to disclose your personally identifiable information as required by law and when we believe that disclosure doing so in the Company's interest to protect its property or other legal rights or the rights or property of others.</p>
<p>Should the company have its assets sold to or merge with another business entity, we reserve the right to transfer the information we receive from this website including your personally identifiable information to a successor as a result of any such corporate reorganization.</p>
<h2>Retention of information</h2>
<p>We will keep personally identifiable Information of our users for as long as they are registered subscribers or users of our products and services, and as permitted by law.</p>
<h2>Information correction</h2>
<p>To update or correct your personally identifiable information that we hold, you can notify us at contact@tutorialspoint.com</p>
<h2>Information security</h2>
<p>We store all the collected information on our secure servers. As a registered user, you can access your account with a unique user name and a password as selected by you. You are responsible for keeping your password confidential. To ensure better security, we recommend that you choose a strong password containing alphabets, numbers, and special characters, and that you change your password periodically.</p>
<p>We employ the best mechanisms possible to protect your Personal Information, however we cannot be held responsible for any breach of security unless it is caused as a direct result of our negligence. Unfortunately data transmission over the internet is not 100% secure and as a registered user of this website, you agree that we are not accountable for any data loss due to the limitations of the internet which are beyond our control.</p>
<p>In the unlikely event of a breach in security systems, we may notify you through email so that you can take suitable protective measures. You are advised to inform us immediately at contact@tutorialspoint.com in case your user name or password is compromised.</p>
<h2>Third-Party Advertisements</h2>
<p>We use third-party advertising companies to serve ads when you visit our Web site. These companies may use aggregated information (not including your name, address, email address or telephone number) about your visits to this and other Web sites in order to provide advertisements about goods and services of interest to you.</p>
<p>We do not guarantee correctness, viability, validity and availability of information displayed on our website in the form of advertisements. We do not guarantee merchantability or fitness of the advertised information for any particular purpose.</p>
<p>We declare the advertisers and their clients or allied partners are neither our agents, nor partners. We do not provide guarantee for any published information on behalf of any of the advertisers and their clients or allied partners.</p>
<p>If you would like more information about this practice and to know your choices about not having this information used by these companies, please see: <a href="http://www.networkadvertising.org/managing/opt_out.asp" target="_blank" rel="nofollow">http://www.networkadvertising.org/managing/opt_out.asp</a></p>
<h2>International users</h2>
<p>This website is operated from India. If you are an international user visiting from other regions having laws governing data collection and use that may differ from the Indian law, please note that you are transferring your personal data to India, which does not have the same data protection laws. By providing your personal data you consent to the use of your personal data for the uses identified above in accordance with this Privacy Policy.</p>
<h2>Cookies Policy</h2>
<p>We collect cookies to enhance our users experience and we have explained our cookies policy in simple words. You are requested to go through this policy to understand how do we collect and use cookies. <a href="/project2/cookie.php">Cookies Policy</a></p>
<h2>Updates & Contact Info</h2>
<p>From time to time, we may update this Policy. If we do, we’ll notify you by posting the policy on our site with a new effective date. If we make any material changes, we’ll take reasonable steps to notify you in advance of the planned change.</p>
<p>If you have any questions about this privacy policy, please email us! </p>
<p>Last updated: 4th Nov 2019</p>
</div>
<?php
require_once 'footer.php';
?>
</body>
</html>