<?php

namespace App\Controls;

use Nette\Forms;


trait FormControlFactories
{
	public function addContainer(string $name): FormContainer
	{
		return $this[$name] = new FormContainer;
	}


	public function addPreTextArea(string $name, string $label = null, int $cols = null, int $rows = null): Forms\Controls\TextArea
	{
		$control = $this[$name] = new Forms\Controls\TextArea($label);
		$control->setAttribute('cols', $cols)->setAttribute('rows', $rows);
		$control->getControlPrototype()->class('pre')->addAttributes([
			'data-real-tabs' => true,
		]);
		return $control;
	}


	public function addStatic(string $name, string $label = null): StaticControl
	{
		return $this[$name] = new StaticControl($label);
	}


//	public function addIPAddress(string $name, int $type, string $label = null): IPAddressControl
//	{
//		return $this[$name] = new IPAddressControl($type, $label);
//	}


//	public function addMacAddress(string $name, string $label = null): MacAddressControl
//	{
//		return $this[$name] = new MacAddressControl($label);
//	}


//	public function addHostname(string $name, string $label = null, array $domains = []): HostnameControl
//	{
//		$control = $this[$name] = new HostnameControl($label);
//		$control->setDomains($domains);
//		return $control;
//	}


//	public function addPassword(string $name, string $label = null, int $cols = null, int $maxLength = null): PasswordControl
//	{
//		return $this[$name] = new PasswordControl($label, $cols, $maxLength);
//	}


//	public function addBoolean(string $name, string $label = null): BooleanControl
//	{
//		return $this[$name] = new BooleanControl($label);
//	}


//	public function addDynamic(string $name, callable $factory, int $defaultCount = 1): DynamicFormContainer
//	{
//		return $this[$name] = new DynamicFormContainer($factory, $defaultCount);
//	}
}
