<?php
	/*
	 * Copyright © 2012 by Eric Schultz.
	 *
	 * Issued under the MIT License
	 *
	 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), 
	 * to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
	 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
	 *
	 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
	 *
	 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
	 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	 */
	 
	set_time_limit(90);

	include 'config.php';

	// Make sure the configuration is setup
	if (!isset($arrConfig) || empty($arrConfig)) {
		error_log("GitHub Webhook Error: missing config.php or no configuration definitions setup");
		exit;
	}

	// Check for the GitHub WebHook Payload
	if (!isset($_POST['payload'])) {
		error_log("GitHub Webhook Error: missing expected POST parameter 'payload'");
		exit;
	}

	// Grab the tastylious JSON payload from GitHub
	$objPayload = json_decode($_POST['payload']);

	// Loop through the configs to see which one matches the payload
	foreach ($arrConfig as $strSiteName => $arrSiteConfig) {
		
		// Merge in site config defaults
		$arrSiteConfig = array_merge(
			array(
				'repository' => '*',
				'branch' => '*',
				'username' => '*',
				'execute' => array()
			), 
			$arrSiteConfig
		);

		$boolPassesChecks = TRUE;

		// Repository name check
		if (($arrSiteConfig['repository'] != '*') && ($arrSiteConfig['repository'] != $objPayload->repository->name)) {
			$boolPassesChecks = FALSE;
		}
		
		// Branch name check
		if (($arrSiteConfig['branch'] != '*') && ('refs/heads/'.$arrSiteConfig['branch'] != $objPayload->ref)) {
			$boolPassesChecks = FALSE;
		}
		
		// Username name check
		if (($arrSiteConfig['username'] != '*') && ($arrSiteConfig['username'] != $objPayload->head_commit->committer->username)) {
			$boolPassesChecks = FALSE;
		}

		// Execute the commands if we passed all the checks
		if ($boolPassesChecks) {
			$arrSiteConfig['execute'] = (array)$arrSiteConfig['execute'];

			foreach ($arrSiteConfig['execute'] as $arrCommand) {
				$arrOutput = array();
				exec($arrCommand, $arrOutput);

				if (isset($boolDebugLogging) && $boolDebugLogging) {
					error_log("GitHub Webhook Update (" . $strSiteName . "):\n" . implode("\n", $arrOutput));
				}
			}
		}
	}