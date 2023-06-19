<?php

namespace Drupal\shruthi_exercise\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drush\Commands\DrushCommands;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class DrushHelpersCommands extends DrushCommands {

  /**
   * @var Drupal\Core\Entity\EntityTypeManagerInterface $entityManager
   *    Entity manager service.
   */

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityManager = $entityTypeManager;
    parent::__construct();
  }

  /**
   * Command that returns a list of all blocked users.
   *
   * @field-labels
   *  id: User Id
   *  name: User Name
   *  email: User Email
   * @default-fields id,name,email
   *
   * @usage drush-helpers:editor
   *   Returns all editor users
   *
   * @command drush-helpers:editor
   * @aliases active-editor
   *
   * @return \Consolidation\OutputFormatters\StructuredData\RowsOfFields
   */
  public function blockedUsers() {
    $users = $this->entityManager->getStorage('user')->loadByProperties(['status' => 1]);
    $rows = [];
    foreach ($users as $user) {
      if ($user->hasRole('editor')) {
        $rows[] = [
          'id' => $user->id(),
          'name' => $user->name->value,
          'email' => $user->mail->value,
        ];
      }
    }
    return new RowsOfFields($rows);
  }

}