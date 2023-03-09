<?php

declare(strict_types=1);

namespace App\Services;

class FlashNotification
{
    public function __construct(
        public string $variant = 'success',
        public string $message = '',
        public string $title = 'Successfully saved!',
        public string $icon = 'check',
        public array $actions = [
            'label' => null,
            'url' => null,
            'method' => null,
            'data' => [],
        ],
    ) {
    }

    public function create(string $prefixMessage, array $actions = []): void
    {
        $this->message = $prefixMessage.' has been added.';
        $this->actions = $actions;

        $this->flash();
    }

    public function update(string $prefixMessage, array $actions = []): void
    {
        $this->message = $prefixMessage.' has been changed.';
        $this->title = 'Successfully updated!';
        $this->actions = $actions;

        $this->flash();
    }

    public function destroy(string $prefixMessage, array $actions = []): void
    {
        $this->variant = 'danger';
        $this->message = $prefixMessage.' has been removed.';
        $this->title = 'Successfully removed!';
        $this->icon = 'trash';
        $this->actions = $actions;

        $this->flash();
    }

    public function restore(string $prefixMessage, array $actions = []): void
    {
        $this->variant = 'warning';
        $this->message = $prefixMessage.' has been restored.';
        $this->title = 'Successfully restored!';
        $this->icon = 'restore';
        $this->actions = $actions;

        $this->flash();
    }

  public function info(string $message, array $actions = []): void
  {
      $this->variant = 'info';
      $this->message = $message;
      $this->title = 'Information';
      $this->icon = 'info';
      $this->actions = $actions;

      $this->flash();
  }

  public function warning(string $message, array $actions = []): void
  {
      $this->variant = 'warning';
      $this->message = $message;
      $this->title = 'Warning';
      $this->icon = 'warning';
      $this->actions = $actions;

      $this->flash();
  }

  public function error(string $message = 'Something went wrong', array $actions = []): void
  {
      $this->variant = 'danger';
      $this->message = $message;
      $this->title = 'Error';
      $this->icon = 'error';
      $this->actions = $actions;

      $this->flash();
  }

    public function flash(): void
    {
        session()->flash('notification', [
            'variant' => $this->variant,
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'actions' => $this->actions,
        ]);
    }
}
