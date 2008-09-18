<?php

// from ticketsf: https://iaml.svn.sourceforge.net/svnroot/iaml/trunk/benchmarks/ticketsf/apps/frontend/lib/autoLoginFilter.php
// based on http://www.symfony-project.org/cookbook/1_0/cookie
// could have also initially used the sfGuard plugin

class autoLoginFilter extends sfFilter {

	public function execute ($filterChain) {
		// execute this filter only once
		if ($this->isFirstCall()) {

			if (!$this->getContext()->getUser() || !$this->getContext()->getUser()->getUserObject()) {

				if ($login_key = $this->getContext()->getRequest()->getCookie("fridge_autologin")) {

					// don't login if we have recently logged out
					if (!$this->getContext()->getRequest()->getCookie("fridge_autologin_disable")) {
						$user = User::loginWithLoginKey($login_key, $this->getContext());

						if (!$user) {
							// delete the cookie if the login key has failed
							$this->getContext()->getResponse()->setCookie("fridge_autologin", 0, -1, '/');
						}
					}
				}
			}
		}

		// execute next filter
		$filterChain->execute();
	}
}
