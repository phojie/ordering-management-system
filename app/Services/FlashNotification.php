<?php

declare(strict_types=1);

namespace App\Services;

class FlashNotification
{
	public string $variant;

	public string $message;

	public string $title;

	public string $icon;

	public array $actions = [
		'label' => null,
		'url' => null,
		'method' => null,
		'data' => [],
	];

	public function __construct()
	{
		$this->variant = 'success';
		$this->title = 'Successfully saved';
		$this->icon = 'check';
	}

	public function create(string $prefixMessage, array $actions): void
	{
		$this->message = $prefixMessage.' has been created.';
		$this->actions = $actions;

		$this->flash();
	}

	public function update(string $prefixMessage, array $actions = []): void
	{
		$this->message = $prefixMessage.' has been updated.';
		$this->title = 'Successfully updated!';
		$this->actions = $actions;

		$this->flash();
	}

	public function destroy(string $prefixMessage, array $actions = []): void
	{
		$this->variant = 'danger';
		$this->message = $prefixMessage.' has been deleted.';
		$this->title = 'Successfully deleted!';
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

  public function info(string $message, array $actions = []): void {
    $this->variant = 'info';
    $this->message = $message;
    $this->title = 'Information';
    $this->icon = 'info';
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
