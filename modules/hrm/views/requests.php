<style>
    #erp-hr-requests .req-status {
        padding: 5px;
        color: white;
        border-radius: 2px;
    }

    #erp-hr-requests .req-status.status-approved,
    #erp-hr-requests .req-status.status-1,
    #erp-hr-requests .req-status.status-7 {
        background-color: #6ecc26;
    }

    #erp-hr-requests .req-status.status-pending,
    #erp-hr-requests .req-status.status-2 {
        background-color: #ffc111;
    }

    #erp-hr-requests .req-status.status-rejected,
    #erp-hr-requests .req-status.status-3 {
        background-color: rgb(218, 67, 67);
    }
</style>

<div class="wrap erp-hr-requests erp-hr-request-listing" id="erp-hr-requests" v-cloak>
    <h2><?php esc_attr_e( 'People', 'erp' ); ?></h2>

    <?php do_action( 'erp_hr_people_menu', 'requests' ); ?>

    <div class="content-header-section">
        <form method="get">
            <div class="wperp-filter-dropdown">
                <a class="wperp-btn btn--default">
                    <span class="dashicons dashicons-filter"></span>
                    <?php _e( 'Filters', 'erp' ) ?>
                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                </a>

                <div class="erp-dropdown-filter-content" id="erp-dropdown-content">
                    <div class="wperp-filter-panel wperp-filter-panel-default">
                        <h3><?php _e( 'Filter', 'erp' ); ?></h3>
                        
                        <div class="wperp-filter-panel-body">
                            <select name="employee" id="erp-hr-filter-employee" class="erp-hrm-select2" v-model="employee">
                                <option v-for="(id, emp) in allEmployees" :value="id">
                                    {{ emp }}
                                </option>
                            </select>

                            <select name="status" id="erp-hr-filter-status" class="erp-hrm-select2" v-model="status">
                                <option v-for="(key, value) in statusFilter" :value="key">
                                    {{ value }}
                                </option>
                            </select>

                            <input type="text"
                                name="filter_date"
                                id="erp-hr-filter-date"
                                placeholder="<?php esc_attr_e( 'Date range', 'erp' ); ?>">
                        </div>

                        <div class="wperp-filter-panel-footer">
                            <input type="submit"
                                class="wperp-btn btn--cancel btn--filter"
                                @click.prevent="toggleDropdown()"
                                value="<?php _e( 'Cancel', 'erp' ); ?>">
                            
                            <input type="submit"
                                class="wperp-btn btn--reset btn--filter"
                                @click.prevent="resetDropdown()"
                                value="<?php _e( 'Reset', 'erp' ); ?>">
                            
                            <input type="submit"
                                class="wperp-btn btn--primary"
                                @click.prevent="filterData()"
                                value="<?php _e( 'Apply', 'erp' ); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="list-table-wrap erp-hr-requests">
        <div class="list-table-inner">
            <form method="get">
                <div class="tablenav top">
                    <ul v-if="!hasTopNavFilter()" class="subsubsub">
                        <li v-for="( key, filter ) in topNavFilter.data" :class="key">
                            <a href="#"
                                @click.prevent="filterTopNav( key, filter )"
                                class="{{ isCurrentTopNavFilter( key ) ? 'current' : '' }}">
                                {{ filter.label }} 
                                <span class="count">({{ filter.count }})</span>
                            </a> 

                            <span v-if="!isTopNavFilterLastItem( key )">|</span>
                        </li>
                    </ul>

                    <div class="tablenav-pages" :class="paginationClass">
                        <span v-if="items" class="displaying-num">{{ items }} {{ items > 1 ? ' items' : ' item' }}</span>
                        
                        <span class="pagination-links">
                            <span v-if="isFirstPage()" class="tablenav-pages-navspan button" disabled="disabled" aria-hidden="true">«</span>
                            
                            <a v-else class="first-page button" href="#" @click.prevent="goFirstPage()">
                                <span class="screen-reader-text"><?php _e( 'First page', 'erp' ) ?></span>
                                <span aria-hidden="true">«</span>
                            </a>

                            <span v-if="isFirstPage()" class="tablenav-pages-navspan button" disabled="disabled" aria-hidden="true">‹</span>
                            
                            <a v-else class="prev-page button" href="#" @click.prevent="goToPage('prev')">
                                <span class="screen-reader-text"><?php _e( 'Previous page', 'erp' ) ?></span>
                                <span aria-hidden="true">‹</span>
                            </a>

                            <span class="screen-reader-text"><?php _e( 'Current Page', 'erp' ) ?></span>
                            
                            <input type="text"
                                value="1"
                                size="1"
                                class="current-page"
                                id="current-page-selector"
                                v-model="pageNumberInput"
                                aria-describedby="table-paging"
                                @keydown.enter.prevent="goToPage(pageNumberInput)">
                                <?php _e( ' of ', 'erp' ) ?>
                                <span class="total-pages">{{ totalPage }}</span>

                            <span v-if="isLastPage()" class="tablenav-pages-navspan button" disabled="disabled" aria-hidden="true">›</span>

                            <a v-else
                                class="next-page button"
                                href="#"
                                @click.prevent="goToPage('next')">
                                <span class="screen-reader-text"><?php _e( 'Next page', 'erp' ) ?></span>
                                <span aria-hidden="true">›</span>
                            </a>

                            <span v-if="isLastPage()" class="tablenav-pages-navspan button" disabled="disabled" aria-hidden="true">»</span>

                            <a v-else
                                href="#"
                                class="last-page button"
                                @click.prevent="goLastPage()">
                                <span class="screen-reader-text"><?php _e( 'Last page', 'erp' ) ?></span>
                                <span aria-hidden="true">»</span>
                            </a>
                        </span>
                    </div>
                    
                    <br class="clear">
                </div>

                <div class="erp-table-wrapper">
                    <table class="wp-list-table widefat fixed striped requests">
                        <thead>
                            <tr>
                                <td v-if="! hideCb" id="cb" class="manage-column column-cb check-column">
                                    <label class="screen-reader-text" for="cb-select-all-1"><?php _e( 'Select All', 'erp' ); ?></label>
                                    
                                    <input id="cb-select-all-1" v-model="checkAllCheckbox" @change="triggerAllCheckBox()" type="checkbox">
                                </td>

                                <td class="actions bulkactions" v-if="hasBulkAction() && checkboxItems.length" :colspan="columnCount">
                                    <label for="bulk-action-selector-top" class="screen-reader-text"><?php _e( 'Select bulk action', 'erp' ); ?></label>
                                    
                                    <select name="action" id="bulk-action-selector-top" v-model="bulkaction1">
                                        <option value="-1"><?php _e( 'Bulk Actions', 'erp' ); ?></option>
                                        <option v-for="actions in bulkactions" value="{{ actions.id }}">{{ actions.text }}</option>
                                    </select>

                                    <input type="submit" id="doaction" @click.prevent="handleBulkAction(bulkaction1)" class="button action" value="<?php esc_attr_e( 'Apply', 'erp' ); ?>">
                                </td>
                                
                                <td v-if="!checkboxItems.length" v-for="header in tableHeaders" :class="header.class">{{ header.title }}</td>
                            </tr>
                        </thead>

                        <tbody id="the-list">
                            <tr v-if="requests" v-for="request in requests">
                                <th v-if="!hideCb" scope="row" class="check-column vertical-middle">
                                    <input class="vertical-super" type="checkbox" v-model="checkboxItems" name="checkboxItems[]" :value="request.id">
                                </th>

                                <td class="vertical-middle"><a :href="request.employee.url" target="_blank">{{ request.employee.name }}</a></td>
                                
                                <td class="vertical-middle" v-if="request.reason">{{ request.reason.title }}</td>
                                
                                <td class="vertical-middle" v-if="request.item">{{ request.item.name }}</td>
                                
                                <td class="vertical-middle" v-if="request.category">{{ request.category.name }}</td>
                                
                                <td class="vertical-middle" v-if="request.amount">{{ request.amount }}</td>
                                
                                <td class="vertical-middle" v-if="request.trn_date">{{ request.trn_date }}</td>
                                
                                <td class="vertical-middle" v-if="request.date">{{ request.date }}</td>
                                
                                <td class="vertical-middle" v-if="request.start_date">{{ request.start_date }}</td>
                                
                                <td class="vertical-middle" v-if="request.end_date">{{ request.end_date }}</td>
                                
                                <td class="vertical-middle" v-if="request.created && activeTopNav != 'remote_work'">{{ request.created }}</td>
                                
                                <td v-if="request.duration" class="text-center text-green vertical-middle">{{ request.duration.value }}</td>

                                <td class="text-center vertical-middle">
                                    <span class="req-status status-{{ request.status.id }}">{{ request.status.title }}</span>
                                </td>

                                <td class="text-center vertical-middle">
                                    <div class="erp-row-action-dropdown">
                                        <a href="#" @click.prevent="showRowActions($index)" class="erp-row-actions-btn {{ ! request.actions ? disabled : '' }}">
                                            <span class="dashicons dashicons-ellipsis"></span>
                                        </a>

                                        <div id="request-row-actions-{{ $index }}" class="dropdown-content">
                                            <a v-for="(key, action) in request.actions"
                                                href="#"
                                                @click.prevent="onActionClick(request.id, action.id, request.status.id)">
                                                <span v-if="action.class" :class="action.class"></span> {{ action.text }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!requests.length || !isLoaded">
                                <td :colspan="columnCount">
                                    <span v-if="!isLoaded"><?php _e( 'Loading', 'erp' ); ?>...</span>
                                    <span v-else><?php _e( 'No requests found.', 'erp' ); ?></span>
                                </td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td v-if="! hideCb" id="cb" class="manage-column column-cb check-column">
                                    <label class="screen-reader-text" for="cb-select-all-2"><?php _e( 'Select All', 'erp' ); ?></label>
                                    
                                    <input id="cb-select-all-2" v-model="checkAllCheckbox" @change="triggerAllCheckBox()" type="checkbox">
                                </td>

                                <td class="actions bulkactions" v-if="hasBulkAction() && checkboxItems.length" :colspan="columnCount">
                                    <label for="bulk-action-selector-bottom" class="screen-reader-text"><?php _e( 'Select bulk action', 'erp' ); ?></label>
                                    
                                    <select name="action" id="bulk-action-selector-bottom" v-model="bulkaction2">
                                        <option value="-1"><?php _e( 'Bulk Actions', 'erp' ); ?></option>
                                        <option v-for="actions in bulkactions" value="{{ actions.id }}">{{ actions.text }}</option>
                                    </select>
                                    
                                    <input type="submit" id="doaction" @click.prevent="handleBulkAction(bulkaction2)" class="button action" value="<?php esc_attr_e( 'Apply', 'erp' ); ?>">
                                </td>
                                
                                <td v-if="!checkboxItems.length" v-for="header in tableHeaders" :class="header.class">{{ header.title }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="erp-ajax-loader-bg" v-if="ajaxloader"></div>
                    
                    <div class="erp-ajax-loader" v-if="ajaxloader"></div>
                </div>
            </form>
        </div>
    </div>
</div>
