<?php

namespace Petrelli\LiveStatics\Traits\Twill;


/**
 *
 * Trait used to define Twill functions for block rendering
 *
 * You will have to define a 'blocks' attribute in your model that returns a
 * collection of blocks.
 *
 * For example:
 *
 * function getBlocksAttribute()
 * {
 *     InterfaceMapper::resolve('twill.title')
 *     InterfaceMapper::resolve('twill.carousel'),
 *     InterfaceMapper::resolve('twill.image'),
 *     InterfaceMapper::resolve('twill.paragraph')
 * }
 *
 */


trait HasBlocks
{


    /**
     *
     * RenderChilds are not used when mocking.
     * The function prototype remains the same as the one provided with Twill
     * for compatibility.
     *
     */
    public function renderBlocks($renderChilds = true, $blockViewMappings = [], $data = [])
    {

        return $this->blocks->map(function ($block) use ($data, $blockViewMappings) {

            $view = $this->getBlockView($block->type, $blockViewMappings);
            return view($view, $data)->with('block', $block)->render();

        })->implode('');

    }


    private function getBlockView($blockType, $blockViewMappings = [])
    {

        if (empty(config('twill.block_editor.block_views_path'))) {
            throw new \Exception(sprintf('Twill has to be installed to use the hasBlock trait'));
        }

        $view = config('twill.block_editor.block_views_path') . '.' . $blockType;

        if (array_key_exists($blockType, $blockViewMappings)) {
            $view = $blockViewMappings[$blockType];
        }

        return $view;

    }


}
