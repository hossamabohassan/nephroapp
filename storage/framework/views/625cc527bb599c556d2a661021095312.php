<?php if (! $__env->hasRenderedOnce('71d15ba7-026d-4aba-8ef0-ed8b2772b9e3')): $__env->markAsRenderedOnce('71d15ba7-026d-4aba-8ef0-ed8b2772b9e3'); ?>
    <script>
        (function () {
            function initLayout(root) {
                if (root.dataset.topicLayoutInit === 'true') {
                    return;
                }

                root.dataset.topicLayoutInit = 'true';

                const sidebar = root.querySelector('[data-topic-sidebar]');
                const toggle = root.querySelector('[data-topic-toggle]');
                const searchInput = root.querySelector('[data-topic-search]');
                const groups = Array.from(root.querySelectorAll('[data-topic-group]'));
                const emptyState = root.querySelector('[data-topic-empty]');
                const expandedLabel = toggle?.querySelector('[data-topic-toggle-label-expanded]');
                const collapsedLabel = toggle?.querySelector('[data-topic-toggle-label-collapsed]');

                const setState = (expanded) => {
                    root.dataset.expanded = expanded ? 'true' : 'false';

                    if (sidebar) {
                        sidebar.classList.toggle('hidden', !expanded);
                        sidebar.classList.toggle('lg:hidden', !expanded);
                    }

                    if (toggle) {
                        toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                        if (expandedLabel) {
                            expandedLabel.classList.toggle('hidden', !expanded);
                        }
                        if (collapsedLabel) {
                            collapsedLabel.classList.toggle('hidden', expanded);
                        }
                    }
                };

                setState(root.dataset.expanded === 'true');

                toggle?.addEventListener('click', () => {
                    const expanded = root.dataset.expanded === 'true';
                    setState(!expanded);
                });

                if (searchInput) {
                    const filter = () => {
                        const value = searchInput.value.trim().toLowerCase();
                        let anyVisible = false;

                        groups.forEach((group) => {
                            const items = Array.from(group.querySelectorAll('[data-topic-item]'));
                            let groupHasMatch = false;

                            items.forEach((item) => {
                                const matches = !value || (item.dataset.topicItem || '').includes(value);
                                item.classList.toggle('hidden', !matches);
                                if (matches) {
                                    groupHasMatch = true;
                                }
                            });

                            group.classList.toggle('hidden', !groupHasMatch);
                            if (groupHasMatch) {
                                anyVisible = true;
                            }
                        });

                        if (emptyState) {
                            emptyState.classList.toggle('hidden', anyVisible);
                        }
                    };

                    filter();
                    searchInput.addEventListener('input', filter);
                }
            }

            function initAll() {
                document.querySelectorAll('[data-topic-layout]').forEach(initLayout);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAll);
            } else {
                initAll();
            }
        })();
    </script>
<?php endif; ?>
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/topics/partials/sidebar-script.blade.php ENDPATH**/ ?>