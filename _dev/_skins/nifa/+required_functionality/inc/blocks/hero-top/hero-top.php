<?php
/**
 * RMcC Hero Top template.
 *
 * @param array $block The block settings and attributes.
 */

namespace Rmcc;

$context = Theme::context();
$context['block'] = $block;
$context['block']['is_preview'] = $is_preview;
$context['block']['controls'] = new HeroTop($context['block']);
$context['block']['fields'] = $context['block']['controls']->block_get_fields();
$context['block']['template'] = array(

    array(
      'core/group',
      array(
        'className' => 'rmcc-container rmcc-container-large',
        'layout' => array(
          'type' => 'default'
        )
      ),
      array(
        array(
          'core/heading',
          array(
            'level' => 5,
            'content' => 'Welcome To',
            'className' => 'rmcc-text-capitalize rmcc-heading-large rmcc-margin-small-bottom'
          ),
          array()
        ),
        array(
          'core/heading',
          array(
            'level' => 1,
            'content' => 'Kilbeggan Community group CLG.',
            'className' => 'rmcc-heading-large rmcc-margin-remove-top gradient-text-bg'
          ),
          array()
        ),
        
      )
    ),
    array(
      'core/group',
      array(
        'className' => 'rmcc-container rmcc-container-small rmcc-margin-top',
        'layout' => array(
          'type' => 'default'
        )
      ),
      array(
        array(
          'core/paragraph',
          array(
            'content' => 'Kilbeggan Community Group CLG supports Community Employment participants in Ballinagore, Ballymore, Castletown Geoghegan , Dysart, Horseleap, Kilbeggan, Loughnavalley, Milltownpass, Rosemount, Streamstown and Tyrrellspass.',
            'className' => 'rmcc-text-large'
          ),
          array()
        ),
        array(
          'core/buttons',
          array(
            'layout' => array(
              'type' => 'flex',
              'justifyContent' => 'center'
            )
          ),
          array(
            array(
              'core/button',
              array(
                'text' => 'View Jobs',
                'textColor' => 'white',
                'className' => 'is-style-outline',
                'style' => array(
                  'elements' => array(
                    'link' => array(
                      'color' => array(
                        'text' => 'var:preset|color|white'
                      )
                    )
                  )
                ),
                'fontSize' => 'medium'
              ),
              array()
            ),
            
          )
        ),
        
      )
    ),

);
Theme::render('hero-top/block.twig', $context);


