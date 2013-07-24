<?php
/**
 * @file
 * Contains \SiteAudit\Check\CronLast.
 */

class SiteAuditCheckCronLast extends SiteAuditCheckAbstract {
  /**
   * Implements \SiteAudit\Check\Abstract\getLabel().
   */
  public function getLabel() {
    return dt('Last run');
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getDescription().
   */
  public function getDescription() {
    return dt('Time Cron last executed');
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getResultFail().
   */
  public function getResultFail() {}

  /**
   * Implements \SiteAudit\Check\Abstract\getResultInfo().
   */
  public function getResultInfo() {
    if ($this->registry['cron_last']) {
      return dt('Cron last ran at @date', array(
        '@date' => date('r', $this->registry['cron_last']),
      ));
    }
    return dt('Cron has never run.');
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getResultPass().
   */
  public function getResultPass() {}

  /**
   * Implements \SiteAudit\Check\Abstract\getResultWarning().
   */
  public function getResultWarning() {}

  /**
   * Implements \SiteAudit\Check\Abstract\getAction().
   */
  public function getAction() {}

  /**
   * Implements \SiteAudit\Check\Abstract\calculateScore().
   */
  public function calculateScore() {
    $this->registry['cron_last'] = variable_get('cron_last');
    return SiteAuditCheckAbstract::AUDIT_CHECK_SCORE_INFO;
  }
}
