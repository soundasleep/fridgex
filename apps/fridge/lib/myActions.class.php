<?php

class myActions extends sfActions {

  /* get the current user object, or logout+notify if the session has expired/user is invalid etc */
  function getUserObject($redir_if_fail = true) {
    $u = $this->getContext()->getUser();
    if ($u) {
      $user = $u->getUserObject();    // get user object
      if ($user) {
        return $user;
      }
      sfContext::getInstance()->getLogger()->debug("{myActions} sf_user doesn't return user object");
    }

    // failed
    if ($redir_if_fail)
      return $this->forceLogin();

  }

  // force the user to login
  function forceLogin() {
    sfContext::getInstance()->getLogger()->info("{myActions} forcing user to login");
    return $this->forward("security", "logout");
  }

  function insufficientRights() {
    sfContext::getInstance()->getLogger()->info("{myActions} user does not have sufficient rights");
    return $this->forward("security", "rights");
  }

  function getContextUser() {
    return $this->getContext()->getUser();
  }

}