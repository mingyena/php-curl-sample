<?php
/**
 * Template Name: doesn't matter... not only in wordpress
 *
 * @package alexis
 * @since 1.0
 */

get_header(); ?>
<div class="row" role="main">
	<div class="col-12">	
	<script>

	</script>
		<?php /* start loop */ ?>
		<?php while (have_posts()) : the_post(); ?>
			<article>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<hr />	
				<div class="entry-content">	


				<H1>sms testing</H1>
				<a href="sms:">Send a SMS</a>
				<h1>This is a test page</h1>


					<?php


					$userEmail="email";
					$token="token";
					$baseApiUrl = 'https://url/api/v1';
					//$uri=$baseApiUrl."/people?access_token=".$token;
					//$uri=$baseApiUrl."/sites/cantersandbox/pages/blogs?".$token;
					$uri=$baseApiUrl."something"";

					//$curl = curl_init($uri);

					//only initial... no fancy url = =|||
					$curl=curl_init();


					<!--only add header if it only accept jasn-->
					<!--/////////check above quote==========-->
					$headers = array(

    							'Accept: application/json',
    							'Content-type: application/json',
								);
					
					
				
					//https://support.ladesk.com/061754-How-to-make-REST-calls-in-PHP
					
					//////GET/////// 
					
					$curl = curl_init($uri);
					//$headers = array();
					//$headers[] = 'Accept: application/json';
					//$headers[] = 'Content-Type: application/json';
					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					$curl_response = curl_exec($curl);
					if ($curl_response === false) {
					    $info = curl_getinfo($curl);
					    curl_close($curl);
					    die('error occured during curl exec. Additioanl info: ' . var_export($info));
					}
					curl_close($curl);
					$decoded = json_decode($curl_response);
					if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
					    die('error occured: ' . $decoded->response->errormessage);
					}
					//print_r ($decoded);
					$peopleInfo = json_decode(json_encode($decoded), true);
					$firstName= ($peopleInfo["person"]["first_name"]);
					$currentCapitalsinCents=$peopleInfo["person"]["capital_amount_in_cents"];
					$currentCapitals = substr(($currentCapitalsinCents),0,-2);
					if(($currentCapitals)==""){
						$currentCapitals=0;
					}
					$spentCapitalsinCents=$peopleInfo["person"]["spent_capital_amount_in_cents"];
					$spentCapitals = substr(($spentCapitalsinCents),0,-2);
					if(($spentCapitals)==""){
						$spentCapitals=0;
					}
					$has_facebook=$peopleInfo["person"]["has_facebook"];
					$has_twitter=$peopleInfo["person"]["twitter_name"];
					
					//////////////////////////////////////////////////////////
					//////Get code End///////////////////////////////////////
					/////HTML PAGE/////////////////////////////////////////
					?>
					

					<h1>Hello <?php echo $firstName;?>, welcome back!</h1>
					<h2>Your Political Capitals</h2>
					<p>Your current politial capitals: <?php echo $currentCapitals; ?>pc</p>

					<p>Your current spent politial capitals: <?php echo $spentCapitals; ?>pc</p>

					<!--facebook-->
					<h2>Complete your Profile</h2>
					<?php
						if($has_facebook){

							echo "<p style='color:#7777'>You already connected your facebook account - 5pc</p>";
						}
						else{
							echo "<p>Connect your facebook account";
						}

						if($has_twitter !=""){

							echo "<p style='color:#7777'>You already connected your twiiter account - 5pc</p>";
						}
						else{
							echo "<p>Connect your twitter account";
						}
					?>

					<!--<iframe src="some iframe src">-->
					<h1>Redeem 5 points</h1>
					<form action="/" method="POST">
						  <input type="checkbox" name="redeem" value="cap"> Redeem for a cap! - 5pc
 						 <br><br>
  						 <input type="submit" value="Submit">
					</form>
					
					<?php
					//////PUT////////////////////////////////////////////////

					$currentCapitalsinCents=(int)$currentCapitalsinCents;
					$currentCapitalsinCents=(int)$currentCapitalsinCents-500;
					$spentCapitalsinCents = $spentCapitalsinCents+500;

					if((($_POST["redeem"])=="cap")&&($currentCapitalsinCents>=500)){
					
					$capRedeem=$_POST["redeem"];
					//$uriPUT= $baseApiUrl."/people/push?".$token;
					$uriPUT=$baseApiUrl."people/something/capitals?".$token;
					/*$curl_put_data = '{"person":
						{
							"email":"'. $userEmail.'",
							"capital_amount_in_cents":'. $currentCapitalsinCents.',
							"spent_capital_amount_in_cents":'. $spentCapitalsinCents.',
						}
					}';*/

					$curl_put_data='{
  {
  "capital": {
    "amount_in_cents": -500,
    "content": "Cap"
  }
}';

					$headers = array(

					'Accept: application/json',
					'Content-type: application/json',
					);


					$curl = curl_init();
					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
					curl_setopt($curl, CURLOPT_URL, $uriPUT);
					curl_setopt($curl, CURLOPT_POSTFIELDS,$curl_put_data);

					
					$curl_response = curl_exec($curl);

					$info = curl_getinfo($curl);

						if ($curl_response === false) {
						    //curl_close($curl);
						    var_dump ($info);
						    die('error occured during curl exec. Additioanl info: ' . var_dump($info));
						    echo "<br/>";
						}

						
						$decoded = json_decode($curl_response);

						if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
						    die('error occured: ' . $decoded->response->errormessage);
						}
						curl_close($curl);
						//echo 'response ok!';
						print_r ($decoded);
					
					

					}


					if((($_POST["redeem"])=="cap")&&($currentCapitalsinCents<500)){
						echo "<p> You don't have enoght political capital</p>";
					}

					/////////////////////POST//////////////////////////////////////
					//next example will insert new conversation
						$service_url = 'https://some url with token = =';
						$curl = curl_init($service_url);
						$curl_post_data =   '{
							  "capital": {
							    "amount_in_cents": -500,
							    "content": "test for api"
							  }
							}';
						curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
						$curl_response = curl_exec($curl);
						if ($curl_response === false) {
						    $info = curl_getinfo($curl);
						    curl_close($curl);
						    die('error occured during curl exec. Additioanl info: ' . var_export($info));
						}
						curl_close($curl);
						$decoded = json_decode($curl_response);
						if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
						    die('error occured: ' . $decoded->response->errormessage);
						}
						print_r ($decoded);
						echo 'post response ok!';
						var_export($decoded->response);
					


					////////POST/////////////////////////////////////////////////////////////

					/*$curl_post_data = '{"blog":{"name": "Testing123","status": "published"}}';

					$uriPOST = "https://someurl with token";


					//$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $uriPOST);
					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					//curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
					//echo json_encode($curl_post_data);
				



					
					//curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);

					$curl_response = curl_exec($curl);
					$info = curl_getinfo($curl);

					echo "POST info<br/>";
					print_r ($info);


					if ($curl_response === false) {
					    $info = curl_getinfo($curl);
					    curl_close($curl);

					    die('error occured during curl exec. Additioanl info: ' . var_export($info));
					}
					curl_close($curl);
					$decoded = json_decode($curl_response);
					
					if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
					    die('error occured: ' . $decoded->response->errormessage);
					}
					echo 'response ok!';
					echo ($decoded->response->status);
					*/

					?>


	  			</div>	
					//////////////////////////////////////////////////////////
					//////Get code End///////////////////////////////////////
					/////HTML PAGE/////////////////////////////////////////
					?>


	  			</div>
	  			<div class="pagelink"><?php wp_link_pages(); ?></div>  			
			</article>
		<?php endwhile; // end the loop ?>
		<?php if ( comments_open() || get_comments_number() ) {
			comments_template( '', true );
		} ?>
	</div>		
</div> <!-- row -->		

