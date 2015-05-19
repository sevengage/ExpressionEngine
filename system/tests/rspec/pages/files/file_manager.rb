class FileManager < ControlPanelPage
	set_url_matcher /files/

  # Title/header box elements
	element :title, 'div.box.full.mb form h1'
	element :title_toolbar, 'div.box.full.mb form h1 ul.toolbar'
	element :download_all, 'div.box.full.mb form h1 ul.toolbar li.download'
	element :phrase_search, 'fieldset.tbl-search input[name=search]'
	element :search_submit_button, 'fieldset.tbl-search input.submit'

	# Sidebar elements
	element :sidebar, 'div.sidebar'
	element :upload_directories_header, 'div.sidebar h2:first-child'
	element :new_directory_button, 'div.sidebar h2:first-child a.btn.action'
	element :watermarks_header, 'div.sidebar h2:nth-child(3)'
	element :new_watermark_button, 'div.sidebar h2:nth-child(3) a.btn.action'
	elements :folder_list, 'div.sidebar div.scroll-wrap ul.folder-list li'

	# Main box elements
	element :breadcrumb, 'ul.breadcrumb'
	element :heading, 'div.col.w-12 div.box form h1'
	element :sync_button, 'div.col.w-12 div.box form h1 ul.toolbar li.sync'
	element :upload_new_file_button, 'div.col.w-12 div.box form fieldset.tbl-search.right a.action'
	element :upload_new_file_filter, 'div.col.w-12 div.box form fieldset.tbl-search.right div.filters ul li a.has-sub'
	element :upload_new_file_filter_menu, 'div.col.w-12 div.box form fieldset.tbl-search.right div.filters ul li div.sub-menu', visible: false
	element :upload_new_file_manual_filter, 'div.col.w-12 div.box form fieldset.tbl-search.right div.filters ul li div.sub-menu fieldset.filter-search input', visible: false
	elements :upload_new_file_filter_menu_items, 'div.col.w-12 div.box form fieldset.tbl-search.right div.filters ul li div.sub-menu ul li', visible: false

	element :perpage_filter, 'div.col.w-12 div.box form h1 + div.filters ul li:first-child'
	element :perpage_filter_menu, 'div.col.w-12 div.box form h1 + div.filters ul li:first-child div.sub-menu ul', visible: false
	element :perpage_manual_filter, 'input[name="perpage"]', visible: false

	# Main box's table elements
	elements :files, 'div.box form div.tbl-wrap table tr'
	element :selected_file, 'div.box form div.tbl-wrap table tr.selected'

	element :title_name_header, 'div.box form div.tbl-wrap table tr th:first-child'
	element :file_type_header, 'div.box form div.tbl-wrap table tr th:nth-child(2)'
	element :date_added_header, 'div.box form div.tbl-wrap table tr th:nth-child(3)'
	element :manage_header, 'div.box form div.tbl-wrap table tr th:nth-child(4)'
	element :checkbox_header, 'div.box form div.tbl-wrap table tr th:nth-child(5)'

	elements :title_names, 'div.box form div.tbl-wrap table tr td:first-child'
	elements :file_types, 'div.box form div.tbl-wrap table tr td:nth-child(2)'
	elements :dates_added, 'div.box form div.tbl-wrap table tr td:nth-child(3)'
	elements :manage_actions, 'div.box form div.tbl-wrap table tr td:nth-child(4)'

	element :bulk_action, 'form fieldset.tbl-bulk-act select[name="bulk_action"]'
	element :action_submit_button, 'form fieldset.tbl-bulk-act button.submit'

	element :no_results, 'tr.no-results'

	element :view_modal, 'div.modal-view-file', visible: false
	element :view_modal_header, 'div.modal-view-file h1'

	def load
		click_link 'Files'
	end

end