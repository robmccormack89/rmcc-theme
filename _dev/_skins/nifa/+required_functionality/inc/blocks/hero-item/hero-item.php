<?php
/**
 * RMcC Hero Item template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new HeroItem($context['block']);
$context['block']['fields'] = $context['block']['controls']->block_get_fields();
$context['block']['template'] = array(
  array(
    'core/group',
    array(
      'layout' => array(
        'type' => 'default'
      )
    ),
    array(
      array(
        'core/columns',
        array(),
        array(
          array(
            'core/column',
            array(
              'width' => '65%'
            ),
            array(
              array(
                'core/paragraph',
                array(
                  'content' => 'Who We Are',
                  'className' => 'rmcc-text-bold rmcc-text-emphasis'
                ),
                array()
              ),
              array(
                'core/heading',
                array(
                  'content' => 'We work tirelessly alongside our sponsors to help participants gain meaningful & practical work experience.',
                  'className' => 'rmcc-text-normal rmcc-margin-remove-top'
                ),
                array()
              ),
              
            )
          ),
          array(
            'core/column',
            array(
              'verticalAlignment' => 'bottom',
              'width' => '33.33%',
              'layout' => array(
                'type' => 'default'
              )
            ),
            array(
              array(
                'core/buttons',
                array(
                  'layout' => array(
                    'type' => 'flex',
                    'verticalAlignment' => 'bottom',
                    'justifyContent' => 'right',
                    'flexWrap' => 'wrap'
                  )
                ),
                array(
                  array(
                    'core/button',
                    array(
                      'text' => 'Learn more',
                      'textAlign' => 'center',
                      'className' => 'is-style-outline'
                    ),
                    array()
                  ),
                  
                )
              ),
              
            )
          ),
          
        )
      ),
      
    )
  ),
);
Theme::render('hero-item/block.twig', $context);