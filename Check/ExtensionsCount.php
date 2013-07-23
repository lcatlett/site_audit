<?php
/**
 * @file
 * Contains \SiteAudit\Check\ExtensionsCount.
 */

class SiteAuditCheckExtensionsCount extends SiteAuditCheckAbstract {
  /**
   * Implements \SiteAudit\Check\Abstract\getLabel().
   */
  public function getLabel() {
    return dt('Count');
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getDescription().
   */
  public function getDescription() {
    return dt('Count the number of enabled extensions (modules and themes) in a site.');
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getResultFail().
   */
  public function getResultFail() {}

  /**
   * Implements \SiteAudit\Check\Abstract\getResultInfo().
   */
  public function getResultInfo() {}

  /**
   * Implements \SiteAudit\Check\Abstract\getResultPass().
   */
  public function getResultPass() {
    return dt('There are @extension_count extensions enabled.', array(
      '@extension_count' => $this->registry['extension_count'],
    ));
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getResultWarning().
   */
  public function getResultWarning() {
    return dt('There are @extension_count extensions enabled; that\'s higher than the average.', array(
      '@extension_count' => $this->registry['extension_count'],
    ));
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getAction().
   */
  public function getAction() {
    if ($this->score != SiteAuditCheckAbstract::AUDIT_CHECK_SCORE_PASS) {
      $output = array();
      $output[] = dt('Consider the following options:');
      $output[] = '    - ' . dt('Disable unneeded or unnecessary extensions.');
      $output[] = '    - ' . dt('Consolidate functionality if possible, or custom develop a solution specific to your needs.');
      $output[] = '    - ' . dt('Avoid using modules that serve only one small purpose that is not mission critical.');
      $output[] = dt('A lightweight site is a fast and happy site!');
      if ($this->html) {
        return implode('<br/>', $output);
      }
      return implode(PHP_EOL, $output);
    }
  }

  /**
   * Implements \SiteAudit\Check\Abstract\calculateScore().
   */
  public function calculateScore() {
    $this->registry['extension_count'] = 0;
    $extension_info = drush_get_extensions(FALSE);

    foreach ($extension_info as $key => $extension) {
      $status = drush_get_extension_status($extension);
      if (!in_array($status, array('enabled'))) {
        unset($extension_info[$key]);
        continue;
      }
      $this->registry['extension_count']++;
    }

    if ($this->registry['extension_count'] >= 150) {
      return SiteAuditCheckAbstract::AUDIT_CHECK_SCORE_WARN;
    }
    return SiteAuditCheckAbstract::AUDIT_CHECK_SCORE_PASS;
  }
}