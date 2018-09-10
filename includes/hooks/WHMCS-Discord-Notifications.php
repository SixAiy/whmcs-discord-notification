<?php
$GLOBALS['discordWebHookURL'] = "https://discordapp.com/api/webhooks/449772500726054912/SXB-RB-RZwjne8QLi-tRayxpjlyXFgPE1UplTuy421gaPJ9BW114DYwXAg7Xqmrtkgl2";
$GLOBALS['whmcsAdminURL'] = "https://bladeportal.net/scp/";
$GLOBALS['DiscordGroup'] = "@everyone";
add_hook('CancellationRequest', 1, function($vars) {
   
  $DiscordMessage = "". json_encode([
     	'content' => $GLOBALS['DiscordGroup'] . ' New Cancellation Request',
	'embeds' => [
		[
		'title' => $vars['reason'],
        'url' => $GLOBALS['whmcsAdminURL'] .  'cancelrequests.php',
        'timestamp' => date(DateTime::ISO8601),
        'description' => '',
			'fields' => [
				[
				'name' => 'Product ID',
                        'value' => $vars['relid'],
                        'inline' => true
				],
				[
				 'name' => 'Cancellation Type',
                        'value' => $vars['type'],
                        'inline' => true
				],
				[
				 'name' => 'User ID',
                        'value' => $vars['userid'],
                        'inline' => true
				]
			]
		]
	]
]);

    processNotification($DiscordMessage, $GLOBALS['discordWebHookURL'] );
});
add_hook('TicketUserReply', 1, function($vars)	{
 
 $DiscordMessage = "". json_encode([
     	'content' => $GLOBALS['DiscordGroup'] . ' New Ticket Reply',
	'embeds' => [
		[
		'title' => $vars['subject'],
        'url' => $GLOBALS['whmcsAdminURL'] . 'supporttickets.php?action=view&id=' . $vars['ticketid'],
        'timestamp' => date(DateTime::ISO8601),
        'description' => $vars['message'],
			'fields' => [
				[
				 'name' => 'Priority',
                        'value' => $vars['priority'],
                        'inline' => true
				],
				[
					'name' => 'Department',
                        'value' => $vars['deptname'],
                        'inline' => true
				],
				[
				 'name' => 'Ticket ID',
                        'value' => $vars['ticketid'],
                        'inline' => true
				]
			]
		]
	]
]);

    processNotification($DiscordMessage, $GLOBALS['discordWebHookURL'] );
});
add_hook('TicketOpen', 1, function($vars)	{
   
    $DiscordMessage = "". json_encode([
     	'content' => $GLOBALS['DiscordGroup'] . ' New Support Ticket',
	'embeds' => [
		[
		'title' => $vars['subject'],
        'url' => $GLOBALS['whmcsAdminURL'] . 'supporttickets.php?action=view&id=' . $vars['ticketid'],
        'timestamp' => date(DateTime::ISO8601),
        'description' => $vars['message'],
			'fields' => [
				[
				 'name' => 'Priority',
                        'value' => $vars['priority'],
                        'inline' => true
				],
				[
					'name' => 'Department',
                        'value' => $vars['deptname'],
                        'inline' => true
				],
				[
				 'name' => 'Ticket ID',
                        'value' => $vars['ticketid'],
                        'inline' => true
				]
			]
		]
	]
]);

    processNotification($DiscordMessage, $GLOBALS['discordWebHookURL'] );
});
add_hook('InvoicePaid', 1, function($vars)	{

    $DiscordMessage = "". json_encode([
     	'content' => $GLOBALS['DiscordGroup'] . ' An invoice has been Paid',
	'embeds' => [
		[
		'title' => 'Invoice #' . $vars['invoiceid'],
        'url' => $GLOBALS['whmcsAdminURL'] . 'viewinvoice.php?id=' . $vars['invoiceid'],
        'timestamp' => date(DateTime::ISO8601)
		]
		]
	
]);

    processNotification($DiscordMessage, $GLOBALS['discordWebHookURL'] );
});



function processNotification($DiscordMessage, $hook)	{
	
$ch = curl_init($hook);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $DiscordMessage);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
	'Content-Type: application/json',
	'Content-Length: ' . strlen($DiscordMessage)
]);
curl_exec($ch);
curl_close($ch);
}