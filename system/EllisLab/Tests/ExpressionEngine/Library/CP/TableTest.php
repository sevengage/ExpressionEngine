<?php
namespace EllisLab\Tests\ExpressionEngine\Library\CP;

use EllisLab\ExpressionEngine\Library\CP\Table;

class TableTest extends \PHPUnit_Framework_TestCase {

	private $table;

	public function tearDown()
	{
		unset($this->table);
	}

	/**
	 * Test setData() method
	 *
	 * @dataProvider tableDataProvider
	 */
	public function testsTableCreation($config, $data, $expected, $columns, $description)
	{
		$this->table = new Table($config);
		$this->table->setColumns($columns);
		$this->table->setData($data);
		$this->assertEquals($expected, $this->table->viewData(), $description);
	}

	public function tableDataProvider()
	{
		$return = array();

		// Empty table config for now
		$config = array();

		$no_results_empty = array('text' => 'no_rows_returned', 'action_text' => '', 'action_link' => '');

		// Given these columns of input...
		$columns = array(
			'Name',
			'Records',
			'Size',
			'Manage' => array(
				'type'	=> Table::COL_TOOLBAR
			),
			'Status' => array(
				'type'		=> Table::COL_STATUS,
				'encode'	=> TRUE
			),
			array(
				'type'	=> Table::COL_CHECKBOX
			)
		);

		// We should get this on output
		$expected_cols = array(
			'Name' => array(
				'encode'	=> FALSE,
				'sort'		=> TRUE,
				'type'		=> Table::COL_TEXT
			),
			'Records' => array(
				'encode'	=> FALSE,
				'sort'		=> TRUE,
				'type'		=> Table::COL_TEXT
			),
			'Size' => array(
				'encode'	=> FALSE,
				'sort'		=> TRUE,
				'type'		=> Table::COL_TEXT
			),
			'Manage' => array(
				'encode'	=> FALSE,
				'sort'		=> FALSE,
				'type'		=> Table::COL_TOOLBAR
			),
			'Status' => array(
				'encode'	=> TRUE,
				'sort'		=> TRUE,
				'type'		=> Table::COL_STATUS
			),
			array(
				'encode'	=> FALSE,
				'sort'		=> FALSE,
				'type'		=> Table::COL_CHECKBOX
			)
		);

		// And with this input of table data...
		$data = array(
			array(
				'col 1 data',
				'col 2 data',
				'col 3 data',
				array('toolbar_items' =>
					array('view' => 'http://test/')
				),
				'status',
				array('name' => 'table[]', 'value' => 'test')
			),
			array(
				'col 1 data 2',
				'col 2 data 2',
				NULL,
				array('toolbar_items' =>
					array('view' => 'http://test/2')
				),
				'status',
				array('name' => 'table[]', 'value' => 'test2')
			)
		);

		// We should get this entire array back when we ask for
		// the table's view data
		$expected = array(
			'base_url'		=> NULL,
			'lang_cols'		=> TRUE,
			'search'		=> NULL,
			'wrap'			=> TRUE,
			'no_results'	=> $no_results_empty,
			'sort_col'		=> 'Name',
			'sort_dir'		=> 'asc',
			'limit'			=> 20,
			'page'			=> 1,
			'total_rows'	=> 2,
			'columns'		=> $expected_cols,
			'data'			=> array(
				array(
					array(
						'content' 	=> 'col 1 data',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 2 data',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 3 data',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_TOOLBAR,
						'encode'	=> FALSE,
						'toolbar_items'	=> array('view' => 'http://test/'),
					),
					array(
						'content' 	=> 'status',
						'type'		=> Table::COL_STATUS,
						'encode'	=> TRUE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_CHECKBOX,
						'encode'	=> FALSE,
						'name'		=> 'table[]',
						'value'		=> 'test'
					)
				),
				array(
					array(
						'content' 	=> 'col 1 data 2',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 2 data 2',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> NULL,
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_TOOLBAR,
						'encode'	=> FALSE,
						'toolbar_items'	=> array('view' => 'http://test/2'),
					),
					array(
						'content' 	=> 'status',
						'type'		=> Table::COL_STATUS,
						'encode'	=> TRUE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_CHECKBOX,
						'encode'	=> FALSE,
						'name'		=> 'table[]',
						'value'		=> 'test2'
					)
				)
			)
		);

		$return[] = array($config, $data, $expected, $columns, 'Test sample table creation');

		$expected = array(
			'base_url'		=> NULL,
			'lang_cols'		=> TRUE,
			'search'		=> NULL,
			'wrap'			=> TRUE,
			'no_results'	=> $no_results_empty,
			'sort_col'		=> NULL,
			'sort_dir'		=> 'asc',
			'limit'			=> 20,
			'page'			=> 1,
			'total_rows'	=> 0,
			'columns'		=> array(),
			'data'			=> array()
		);

		$return[] = array($config, array(), $expected, array(), 'Test empty table');

		$expected = array(
			'base_url'		=> NULL,
			'lang_cols'		=> TRUE,
			'search'		=> NULL,
			'wrap'			=> TRUE,
			'no_results'	=> $no_results_empty,
			'sort_col'		=> 'Name',
			'sort_dir'		=> 'asc',
			'limit'			=> 20,
			'page'			=> 1,
			'total_rows'	=> 0,
			'columns'		=> $expected_cols,
			'data'			=> array()
		);

		$return[] = array($config, array(), $expected, $columns, 'Test table with columns but no data');

		$no_results = array('text' => 'no_results', 'action_text' => 'test', 'action_link' => 'test');

		$config = array(
			'wrap'			=> FALSE,
			'sort_col'		=> 'Some column',
			'sort_dir'		=> 'desc',
			'search'		=> 'My search',
			'no_results'	=> $no_results
		);

		$expected = array(
			'base_url'		=> NULL,
			'lang_cols'		=> TRUE,
			'search'		=> 'My search',
			'wrap'			=> FALSE,
			'no_results'	=> $no_results,
			'sort_col'		=> 'Some column',
			'sort_dir'		=> 'desc',
			'limit'			=> 20,
			'page'			=> 1,
			'total_rows'	=> 0,
			'columns'		=> $expected_cols,
			'data'			=> array()
		);

		$return[] = array($config, array(), $expected, $columns, 'Test with alternate config');

		$config = array(
			'autosort'	=> FALSE,
			'lang_cols'	=> FALSE,
			'sort_col'	=> 'Name',
			'sort_dir'	=> 'desc',
			'limit'		=> 50
		);

		$expected = array(
			'base_url'		=> NULL,
			'lang_cols'		=> FALSE,
			'search'		=> NULL,
			'wrap'			=> TRUE,
			'no_results'	=> $no_results_empty,
			'sort_col'		=> 'Name',
			'sort_dir'		=> 'desc',
			'limit'			=> 50,
			'page'			=> 1,
			'total_rows'	=> 2,
			'columns'		=> $expected_cols,
			'data'			=> array(
				array(
					array(
						'content' 	=> 'col 1 data',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 2 data',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 3 data',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_TOOLBAR,
						'encode'	=> FALSE,
						'toolbar_items'	=> array('view' => 'http://test/'),
					),
					array(
						'content' 	=> 'status',
						'type'		=> Table::COL_STATUS,
						'encode'	=> TRUE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_CHECKBOX,
						'encode'	=> FALSE,
						'name'		=> 'table[]',
						'value'		=> 'test'
					)
				),
				array(
					array(
						'content' 	=> 'col 1 data 2',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 2 data 2',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> NULL,
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_TOOLBAR,
						'encode'	=> FALSE,
						'toolbar_items'	=> array('view' => 'http://test/2'),
					),
					array(
						'content' 	=> 'status',
						'type'		=> Table::COL_STATUS,
						'encode'	=> TRUE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_CHECKBOX,
						'encode'	=> FALSE,
						'name'		=> 'table[]',
						'value'		=> 'test2'
					)
				)
			)
		);

		$return[] = array($config, $data, $expected, $columns, 'Test autosort off');

		$config['autosort'] = TRUE;

		$expected = array(
			'base_url'		=> NULL,
			'lang_cols'		=> FALSE,
			'search'		=> NULL,
			'wrap'			=> TRUE,
			'no_results'	=> $no_results_empty,
			'sort_col'		=> 'Name',
			'sort_dir'		=> 'desc',
			'limit'			=> 50,
			'page'			=> 1,
			'total_rows'	=> 2,
			'columns'		=> $expected_cols,
			'data'		=> array(
				array(
					array(
						'content' 	=> 'col 1 data 2',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 2 data 2',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> NULL,
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_TOOLBAR,
						'encode'	=> FALSE,
						'toolbar_items'	=> array('view' => 'http://test/2'),
					),
					array(
						'content' 	=> 'status',
						'type'		=> Table::COL_STATUS,
						'encode'	=> TRUE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_CHECKBOX,
						'encode'	=> FALSE,
						'name'		=> 'table[]',
						'value'		=> 'test2'
					)
				),
				array(
					array(
						'content' 	=> 'col 1 data',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 2 data',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 3 data',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_TOOLBAR,
						'encode'	=> FALSE,
						'toolbar_items'	=> array('view' => 'http://test/'),
					),
					array(
						'content' 	=> 'status',
						'type'		=> Table::COL_STATUS,
						'encode'	=> TRUE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_CHECKBOX,
						'encode'	=> FALSE,
						'name'		=> 'table[]',
						'value'		=> 'test'
					)
				)
			)
		);

		$return[] = array($config, $data, $expected, $columns, 'Test autosort on');

		$config['search'] = 'data 2';

		$expected = array(
			'base_url'		=> NULL,
			'lang_cols'		=> FALSE,
			'search'		=> 'data 2',
			'wrap'			=> TRUE,
			'no_results'	=> $no_results_empty,
			'sort_col'		=> 'Name',
			'sort_dir'		=> 'desc',
			'limit'			=> 50,
			'page'			=> 1,
			'total_rows'	=> 1,
			'columns'		=> $expected_cols,
			'data'			=> array(
				array(
					array(
						'content' 	=> 'col 1 data 2',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> 'col 2 data 2',
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> NULL,
						'type'		=> Table::COL_TEXT,
						'encode'	=> FALSE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_TOOLBAR,
						'encode'	=> FALSE,
						'toolbar_items'	=> array('view' => 'http://test/2'),
					),
					array(
						'content' 	=> 'status',
						'type'		=> Table::COL_STATUS,
						'encode'	=> TRUE
					),
					array(
						'content' 	=> '',
						'type'		=> Table::COL_CHECKBOX,
						'encode'	=> FALSE,
						'name'		=> 'table[]',
						'value'		=> 'test2'
					)
				)
			)
		);

		$return[] = array($config, $data, $expected, $columns, 'Test autosort search');

		$config['search'] = 'col 1 data 2';
		$expected['search'] = 'col 1 data 2';

		// Because strpos of entire string will return 0, make sure we're === FALSE there
		$return[] = array($config, $data, $expected, $columns, 'Test autosort search with entire string');

		$config['search'] = '';
		$config['limit'] = 1;

		$expected['search'] = '';
		$expected['limit'] = 1;
		$expected['total_rows'] = 2;
		$expected['data'] = array(
			array(
				array(
					'content' 	=> 'col 1 data 2',
					'type'		=> Table::COL_TEXT,
					'encode'	=> FALSE
				),
				array(
					'content' 	=> 'col 2 data 2',
					'type'		=> Table::COL_TEXT,
					'encode'	=> FALSE
				),
				array(
					'content' 	=> NULL,
					'type'		=> Table::COL_TEXT,
					'encode'	=> FALSE
				),
				array(
					'content' 	=> '',
					'type'		=> Table::COL_TOOLBAR,
					'encode'	=> FALSE,
					'toolbar_items'	=> array('view' => 'http://test/2'),
				),
				array(
					'content' 	=> 'status',
					'type'		=> Table::COL_STATUS,
					'encode'	=> TRUE
				),
				array(
					'content' 	=> '',
					'type'		=> Table::COL_CHECKBOX,
					'encode'	=> FALSE,
					'name'		=> 'table[]',
					'value'		=> 'test2'
				)
			)
		);

		$return[] = array($config, $data, $expected, $columns, 'Test pagination');

		$config['limit'] = 1;
		$config['page'] = 2;

		$expected['page'] = 2;
		$expected['data'] = array(
			array(
				array(
					'content' 	=> 'col 1 data',
					'type'		=> Table::COL_TEXT,
					'encode'	=> FALSE
				),
				array(
					'content' 	=> 'col 2 data',
					'type'		=> Table::COL_TEXT,
					'encode'	=> FALSE
				),
				array(
					'content' 	=> 'col 3 data',
					'type'		=> Table::COL_TEXT,
					'encode'	=> FALSE
				),
				array(
					'content' 	=> '',
					'type'		=> Table::COL_TOOLBAR,
					'encode'	=> FALSE,
					'toolbar_items'	=> array('view' => 'http://test/'),
				),
				array(
					'content' 	=> 'status',
					'type'		=> Table::COL_STATUS,
					'encode'	=> TRUE
				),
				array(
					'content' 	=> '',
					'type'		=> Table::COL_CHECKBOX,
					'encode'	=> FALSE,
					'name'		=> 'table[]',
					'value'		=> 'test'
				)
			)
		);

		$return[] = array($config, $data, $expected, $columns, 'Test pagination 2');


		return $return;
	}

	/**
	 * @expectedException InvalidArgumentException
	 * @dataProvider badTableDataProvider
	 */
	public function testsTableThrowsException($config, $data, $columns, $description)
	{
		$this->table = new Table($config);
		$this->table->setColumns($columns);
		$this->table->setData($data);
	}

	public function badTableDataProvider()
	{
		$return = array();

		$config = array();

		$columns = array(
			'Name',
			'Records',
			'Size'
		);

		$data = array(
			array('test', 'test')
		);

		$return[] = array($config, $data, $columns, 'Test column count mismatch');

		$columns = array(
			'Name',
			'Manage' => array(
				'type'	=> Table::COL_TOOLBAR
			),
			array(
				'type'	=> Table::COL_CHECKBOX
			)
		);

		$data = array(
			array(
				'test',
				'test',
				array('name' => 'table[]')
			)
		);

		$return[] = array($config, $data, $columns, 'Test invalid data for checkboxes and toolbars');

		$data = array(
			array(
				'test',
				'test',
				array('name' => 'table[]', 'value' => 'test')
			)
		);

		$return[] = array($config, $data, $columns, 'Test invalid data for toolbars');

		$data = array(
			array(
				'test',
				array('toolbar_items' => array()),
				array('value' => 'test')
			)
		);

		$return[] = array($config, $data, $columns, 'Test invalid data for checkboxes');

		return $return;
	}
}