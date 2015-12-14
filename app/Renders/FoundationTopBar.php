<?php namespace App\Renders;

use Tree\Node\NodeInterface;
use Stolz\Menu\Renders\RenderInterface;

// TODO to-do render <li class="dividier"> separators

class FoundationTopBar implements RenderInterface
{
	public function render(NodeInterface $node)
	{
		if($node->isRoot())
			return $this->renderRoot($node);

		// Get class name without namespace
		$nodeClass = substr(strrchr(get_class($node), '\\'), 1);

		// If a method for rendering this kind of node exists, then delegate
		if(method_exists($this, $renderMethod = "render$nodeClass"))
			return $this->$renderMethod($node);

		return $node->getValue();
	}

	protected function renderRoot(NodeInterface $node)
	{
		$return = null;
		foreach($node->getChildren() as $child)
			$return .=  $this->renderChildren($child);

		return $return;
	}

	protected function renderNode(NodeInterface $node)
	{
		return '
		<li class="has-submenu">
			<a>' . $node->getValue(). '</a>
			<ul class="submenu menu vertical" data-submenu>
			' . $this->renderChildren($node) .
			'</ul>
		</li>';
	}

	protected function renderFlat(NodeInterface $node)
	{
		return '
		<li>
			<label>' . $node->getValue() . '</label>
		</li>
		' . $this->renderChildren($node);
	}

	protected function renderLink(NodeInterface $node)
	{
		if($node->isLeaf())
			return '<li>' . $node->build() . '</li>';

		return '
		<li class="has-submenu">
			' . $node->build(). '
			<ul class="submenu menu vertical" data-submenu>
			' . $this->renderChildren($node) .
			'</ul>
		</li>';
	}

	protected function renderChildren(NodeInterface $node)
	{
		$return = null;
		foreach($node->getChildren() as $child)
			$return .= $child->render();

		return $return;
	}
} 
