<template>

    <div>
        <breadcrumb v-if="breadcrumbs" :url="breadcrumbs[1].url" :title="breadcrumbs[1].text" />

        <div class="flex items-baseline mb-6">
            <h1 class="flex-1 self-start rtl:ml-4 ltr:mr-4">
                <div class="flex items-baseline">
                    <span v-if="! isCreating"
                        class="little-dot rtl:ml-2 ltr:mr-2 -top-1"
                        :class="{ 'bg-green-600': published, 'bg-gray-600': !published }" />
                    <span class="break-overflowing-words" v-html="$options.filters.striptags(title)" />
                </div>
            </h1>

            <dropdown-list class="rtl:ml-4 ltr:mr-4" v-if="canEditBlueprint || hasItemActions">
                <dropdown-item :text="__('Edit Blueprint')" v-if="canEditBlueprint" :redirect="actions.editBlueprint" />
                <li class="divider" />
                <data-list-inline-actions
                    v-if="!isCreating && hasItemActions"
                    :item="values.id"
                    :url="itemActionUrl"
                    :actions="itemActions"
                    :is-dirty="isDirty"
                    @started="actionStarted"
                    @completed="actionCompleted"
                />
            </dropdown-list>

            <div class="pt-px text-2xs text-gray-600 flex rtl:ml-4 ltr:mr-4" v-if="readOnly">
                <svg-icon name="light/lock" class="w-4 rtl:ml-1 ltr:mr-1 -mt-1" /> {{ __('Read Only') }}
            </div>

            <div class="hidden md:flex items-center">

                <save-button-options
                    v-if="!readOnly"
                    :show-options="!revisionsEnabled && !isInline"
                    :button-class="saveButtonClass"
                    :preferences-prefix="preferencesPrefix"
                >
                    <button
                        :class="saveButtonClass"
                        :disabled="!canSave"
                        @click.prevent="save"
                        v-text="saveText"
                    />
                </save-button-options>

                <button
                    v-if="revisionsEnabled"
                    class="rtl:mr-4 ltr:ml-4 btn-primary flex items-center"
                    :disabled="!canPublish"
                    @click="confirmingPublish = true">
                    <span v-text="__('Publish')" />
                    <svg-icon name="micro/chevron-down-xs" class="rtl:mr-2 ltr:ml-2 w-2" />
                </button>
            </div>

            <slot name="action-buttons-right" />
        </div>

        <publish-container
            v-if="fieldset"
            ref="container"
            :name="publishContainer"
            :blueprint="fieldset"
            :values="values"
            :reference="initialReference"
            :meta="meta"
            :errors="errors"
            :site="site"
            :localized-fields="localizedFields"
            :is-root="isRoot"
            @updated="values = $event"
        >
            <live-preview
                slot-scope="{ container, components, setFieldMeta }"
                :name="publishContainer"
                :url="livePreviewUrl"
                :previewing="isPreviewing"
                :targets="previewTargets"
                :values="values"
                :blueprint="fieldset.handle"
                :reference="initialReference"
                @opened-via-keyboard="openLivePreview"
                @closed="closeLivePreview"
            >
                <div>
                    <component
                        v-for="component in components"
                        :key="component.name"
                        :is="component.name"
                        :container="container"
                        v-bind="component.props"
                    />

                    <transition name="live-preview-tabs-drop">
                        <publish-tabs
                            v-show="tabsVisible"
                            :read-only="readOnly"
                            :syncable="hasOrigin"
                            @updated="setFieldValue"
                            @meta-updated="setFieldMeta"
                            @synced="syncField"
                            @desynced="desyncField"
                            @focus="container.$emit('focus', $event)"
                            @blur="container.$emit('blur', $event)"
                        >
                            <template #actions="{ shouldShowSidebar }">
                            <div class="card p-0" :class="{ 'mb-5': showLivePreviewButton || showVisitUrlButton || localizations.length > 1 }">

                                <div :class="{ 'hi': !shouldShowSidebar }">

                                    <div class="p-3 flex flex-wrap items-center gap-2" v-if="showLivePreviewButton || showVisitUrlButton">
                                        <button
                                            class="flex flex-1 items-center justify-center btn px-2"
                                            v-if="showLivePreviewButton"
                                            @click="openLivePreview">
                                            <svg-icon name="light/synchronize" class="h-4 w-4 rtl:ml-2 ltr:mr-2 shrink-0" />
                                            <span>{{ __('Live Preview') }}</span>
                                        </button>
                                        <a
                                            class="flex flex-1 items-center justify-center btn px-2"
                                            v-if="showVisitUrlButton"
                                            :href="permalink"
                                            target="_blank">
                                            <svg-icon name="light/external-link" class="w-4 h-4 rtl:ml-2 ltr:mr-2 shrink-0" />
                                            <span>{{ __('Visit URL') }}</span>
                                        </a>
                                    </div>
                                </div>

                                <!--
                                TODO
                                <div class="flex items-center border-t justify-between px-4 py-2" v-if="!revisionsEnabled">
                                    <label v-text="__('Published')" class="publish-field-label font-medium" />
                                    <toggle-input v-model="published" />
                                </div>

                                <div class="border-t p-4" v-if="revisionsEnabled">
                                    <label class="publish-field-label font-medium mb-2" v-text="__('Revisions')"/>
                                    <div class="mb-1 flex items-center" v-if="published">
                                        <span class="text-green-600 w-6 text-center">&check;</span>
                                        <span class="text-2xs" v-text="__('Entry has a published version')"></span>
                                    </div>
                                    <div class="mb-1 flex items-center" v-else="published">
                                        <span class="text-orange w-6 text-center">!</span>
                                        <span class="text-2xs" v-text="__('Entry has not been published')"></span>
                                    </div>
                                    <div class="mb-1 flex items-center" v-if="isWorkingCopy && isDirty">
                                        <span class="text-orange w-6 text-center">!</span>
                                        <span class="text-2xs" v-text="__('Working copy has unsaved changes')"></span>
                                    </div>
                                    <div class="mb-1 flex items-center" v-else-if="isWorkingCopy">
                                        <span class="text-orange w-6 text-center">!</span>
                                        <span class="text-2xs" v-text="__('Entry has unpublished changes')"></span>
                                    </div>
                                    <div class="mb-1 flex items-center" v-if="!isWorkingCopy && published">
                                        <span class="text-green-600 w-6 text-center">&check;</span>
                                        <span class="text-2xs" v-text="__('This is the published version')"></span>
                                    </div>
                                    <button
                                            class="flex items-center justify-center mt-4 btn-flat px-2 w-full"
                                            v-if="!isCreating && revisionsEnabled"
                                            @click="showRevisionHistory = true">
                                            <svg-icon name="history" class="h-4 w-4 rtl:ml-2 ltr:mr-2" />
                                            <span>{{ __('View History') }}</span>
                                        </button>
                                </div>
                                -->

                                <div class="p-4 border-t dark:border-dark-900" v-if="localizations.length > 1">
                                    <label class="publish-field-label font-medium mb-2" v-text="__('Sites')" />
                                    <div
                                        v-for="option in localizations"
                                        :key="option.handle"
                                        class="text-sm flex items-center -mx-4 px-4 py-2 cursor-pointer"
                                        :class="option.active ? 'bg-blue-100 dark:bg-dark-300' : 'hover:bg-gray-200 dark:hover:bg-dark-400'"
                                        @click="localizationSelected(option)"
                                    >
                                        <div class="flex-1 flex items-center" :class="{ 'line-through': !option.exists }">
                                            <span class="little-dot rtl:ml-2 ltr:mr-2" :class="{
                                                'bg-green-600': option.published,
                                                'bg-gray-500': !option.published,
                                                'bg-red-500': !option.exists
                                            }" />
                                            {{ __(option.name) }}
                                            <loading-graphic :size="14" text="" class="rtl:mr-2 ltr:ml-2" v-if="localizing === option.handle" />
                                        </div>
                                        <div class="badge-sm bg-orange" v-if="option.origin" v-text="__('Origin')" />
                                        <div class="badge-sm bg-blue dark:bg-dark-blue-100" v-if="option.active" v-text="__('Active')" />
                                        <div class="badge-sm bg-purple" v-if="option.root && !option.origin && !option.active" v-text="__('Root')" />
                                    </div>
                                </div>

                            </div>
                            </template>
                        </publish-tabs>
                    </transition>
                </div>
            </live-preview>
        </publish-container>

        <div class="md:hidden mt-6 flex items-center">
            <button
                v-if="!readOnly"
                class="btn-lg"
                :class="{
                    'btn-primary w-full': ! revisionsEnabled,
                    'btn w-1/2 rtl:ml-4 ltr:mr-4': revisionsEnabled,
                }"
                :disabled="!canSave"
                @click.prevent="save"
                v-text="__(revisionsEnabled ? 'Save Changes' : 'Save')" />

            <button
                v-if="revisionsEnabled"
                class="rtl:mr-2 ltr:ml-2 btn-primary btn-lg justify-center flex items-center w-1/2"
                :disabled="!canPublish"
                @click="confirmingPublish = true">
                <span v-text="__('Publish')" />
                <svg-icon name="micro/chevron-down-xs" class="rtl:mr-2 ltr:ml-2 w-2" />
            </button>
        </div>

        <stack name="revision-history" v-if="showRevisionHistory" @closed="showRevisionHistory = false" :narrow="true">
            <revision-history
                slot-scope="{ close }"
                :index-url="actions.revisions"
                :restore-url="actions.restore"
                @closed="close"
            />
        </stack>

        <publish-actions
            v-if="confirmingPublish"
            :actions="actions"
            :published="published"
            :can-manage-publish-state="canManagePublishState"
            @closed="confirmingPublish = false"
            @saving="saving = true"
            @saved="publishActionCompleted"
        />
    </div>

</template>


<script>
import PublishActions from './PublishActions.vue';
import SaveButtonOptions from '../publish/SaveButtonOptions.vue';
import RevisionHistory from '../revision-history/History.vue';
import HasPreferences from '../data-list/HasPreferences';
import HasHiddenFields from '../publish/HasHiddenFields';
import HasActions from '../publish/HasActions';

export default {

    mixins: [
        HasPreferences,
        HasHiddenFields,
        HasActions,
    ],

    components: {
        PublishActions,
        SaveButtonOptions,
        RevisionHistory,
    },

    props: {
        publishContainer: String,
        initialReference: String,
        initialFieldset: Object,
        initialValues: Object,
        initialMeta: Object,
        initialTitle: String,
        initialLocalizations: Array,
        initialLocalizedFields: Array,
        initialHasOrigin: Boolean,
        initialOriginValues: Object,
        initialOriginMeta: Object,
        initialSite: String,
        initialIsWorkingCopy: Boolean,
        taxonomyHandle: String,
        breadcrumbs: Array,
        initialActions: Object,
        method: String,
        initialPublished: Boolean,
        isCreating: Boolean,
        isInline: Boolean,
        initialReadOnly: Boolean,
        initialIsRoot: Boolean,
        initialPermalink: String,
        revisionsEnabled: Boolean,
        preloadedAssets: Array,
        canEditBlueprint: Boolean,
        createAnotherUrl: String,
        listingUrl: String,
        previewTargets: Array,
        hasTemplate: Boolean,
    },

    data() {
        return {
            actions: this.initialActions,
            saving: false,
            localizing: false,
            fieldset: this.initialFieldset,
            title: this.initialTitle,
            values: _.clone(this.initialValues),
            meta: _.clone(this.initialMeta),
            localizations: _.clone(this.initialLocalizations),
            localizedFields: this.initialLocalizedFields,
            hasOrigin: this.initialHasOrigin,
            originValues: this.initialOriginValues || {},
            originMeta: this.initialOriginMeta || {},
            site: this.initialSite,
            isWorkingCopy: this.initialIsWorkingCopy,
            error: null,
            errors: {},
            isPreviewing: false,
            tabsVisible: true,
            state: 'new',
            revisionMessage: null,
            showRevisionHistory: false,
            published: this.initialPublished,
            confirmingPublish: false,
            readOnly: this.initialReadOnly,
            isRoot: this.initialIsRoot,
            permalink: this.initialPermalink,
            preferencesPrefix: `taxonomies.${this.taxonomyHandle}`,
            saveKeyBinding: null,
            quickSaveKeyBinding: null,
            quickSave: false,
        }
    },

    computed: {

        hasErrors() {
            return this.error || Object.keys(this.errors).length;
        },

        somethingIsLoading() {
            return ! this.$progress.isComplete();
        },

        canSave() {
            return !this.readOnly && this.isDirty && !this.somethingIsLoading;
        },

        canPublish() {
            if (!this.revisionsEnabled) return false;

            return !this.readOnly && !this.isCreating && !this.canSave && !this.somethingIsLoading && this.isWorkingCopy;
        },

        livePreviewUrl() {
            return _.findWhere(this.localizations, { active: true }).livePreviewUrl;
        },

        showLivePreviewButton() {
            return !this.isCreating && this.isBase && this.livePreviewUrl && this.showVisitUrlButton;
        },

        showVisitUrlButton() {
            return !!this.permalink && this.hasTemplate;
        },

        isBase() {
            return this.publishContainer === 'base';
        },

        isDirty() {
            return this.$dirty.has(this.publishContainer);
        },

        activeLocalization() {
            return _.findWhere(this.localizations, { active: true });
        },

        saveText() {
            if (this.revisionsEnabled) return __('Save Changes');

            if (this.published) return __('Save & Publish');

            if (!this.published && this.initialPublished) return __('Save & Unpublish');

            return __('Save');
        },

        saveButtonClass() {
            return {
                'btn': this.revisionsEnabled,
                'btn-primary': ! this.revisionsEnabled,
            };
        },

        afterSaveOption() {
            return this.getPreference('after_save');
        },

    },

    watch: {

        published(published) {
            this.$refs.container.dirty();
        },

        saving(saving) {
            this.$progress.loading(`${this.publishContainer}-entry-publish-form`, saving);
        }

    },

    methods: {

        clearErrors() {
            this.error = null;
            this.errors = {};
        },

        save() {
            if (! this.canSave) {
                this.quickSave = false;
                return;
            }

            this.saving = true;
            this.clearErrors();

            this.runBeforeSaveHook();
        },

        runBeforeSaveHook() {
            Statamic.$hooks.run('term.saving', {
                taxonomy: this.taxonomyHandle,
                values: this.values,
                container: this.$refs.container,
                storeName: this.publishContainer,
            })
            .then(this.performSaveRequest)
            .catch(error => {
                this.saving = false;
                this.$toast.error(error || 'Something went wrong');
            });
        },

        performSaveRequest() {
            const payload = { ...this.visibleValues, ...{
                _blueprint: this.fieldset.handle,
                published: this.published,
                _localized: this.localizedFields,
            }};

            this.$axios[this.method](this.actions.save, payload).then(response => {
                this.saving = false;
                if (! response.data.saved) {
                    return this.$toast.error(__(`Couldn't save term`));
                }
                this.title = response.data.data.title;
                this.permalink = response.data.data.permalink;
                this.isWorkingCopy = true;
                if (!this.isCreating) this.$toast.success(__('Saved'));
                this.$refs.container.saved();
                this.runAfterSaveHook(response);
            }).catch(e => this.handleAxiosError(e));
        },

        confirmPublish() {
            if (this.canPublish) {
                this.confirmingPublish = true;
            }
        },

        runAfterSaveHook(response) {
            Statamic.$hooks
                .run('term.saved', {
                    taxonomy: this.taxonomyHandle,
                    reference: this.initialReference,
                    response
                })
                .then(() => {
                    // If revisions are enabled, just emit event.
                    if (this.revisionsEnabled) {
                        this.values = this.resetValuesFromResponse(response.data.data.values);
                        this.$nextTick(() => this.$emit('saved', response));
                        return;
                    }

                    let nextAction = this.quickSave ? 'continue_editing' : this.afterSaveOption;

                    // If the user has opted to create another entry, redirect them to create page.
                    if (!this.isInline && this.afterSaveOption === 'create_another') {
                        window.location = this.createAnotherUrl;
                    }

                    // If the user has opted to go to listing (default/null option), redirect them there.
                    else if (!this.isInline && nextAction === null) {
                        window.location = this.listingUrl;
                    }

                    // Otherwise, leave them on the edit form and emit an event. We need to wait until after
                    // the hooks are resolved because if this form is being shown in a stack, we only
                    // want to close it once everything's done.
                    else {
                        this.values = this.resetValuesFromResponse(response.data.data.values);
                        this.$nextTick(() => this.$emit('saved', response));
                    }

                    this.quickSave = false;
                }).catch(e => {});
        },

        handleAxiosError(e) {
            this.saving = false;
            if (e.response && e.response.status === 422) {
                const { message, errors } = e.response.data;
                this.error = message;
                this.errors = errors;
                this.$toast.error(message);
                this.$reveal.invalid();
            } else {
                this.$toast.error(__('Something went wrong'));
            }
        },

        localizationSelected(localization) {
            if (localization.active) return;

            if (this.isDirty) {
                if (! confirm(__('Are you sure? Unsaved changes will be lost.'))) {
                    return;
                }
            }

            this.localizing = localization.handle;

            if (localization.exists) {
                this.editLocalization(localization);
            } else {
                this.createLocalization(localization);
            }

            if (this.publishContainer === 'base') {
                window.history.replaceState({}, '', localization.url);
            }
        },

        editLocalization(localization) {
            this.$axios.get(localization.url).then(response => {
                const data = response.data;
                this.values = data.values;
                this.originValues = data.originValues;
                this.originMeta = data.originMeta;
                this.meta = data.meta;
                this.localizations = data.localizations;
                this.localizedFields = data.localizedFields;
                this.hasOrigin = data.hasOrigin;
                this.publishUrl = data.actions[this.action];
                this.taxonomy = data.taxonomy;
                this.title = data.editing ? data.values.title : this.title;
                this.actions = data.actions;
                this.fieldset = data.blueprint;
                this.isRoot = data.isRoot;
                this.site = localization.handle;
                this.localizing = false;
                this.$nextTick(() => this.$refs.container.clearDirtyState());
            })
        },

        createLocalization(localization) {
            const url = this.activeLocalization.url + '/localize';
            this.$axios.post(url, { site: localization.handle }).then(response => {
                this.editLocalization(response.data);
            });
        },

        localizationStatusText(localization) {
            if (! localization.exists) return 'This entry does not exist for this site.';

            return localization.published
                ? 'This entry exists in this site, and is published.'
                : 'This entry exists in this site, but is not published.';
        },

        openLivePreview() {
            this.tabsVisible = false;
            this.$wait(200)
                .then(() => {
                    this.isPreviewing = true;
                    return this.$wait(300);
                })
                .then(() => this.tabsVisible = true);
        },

        closeLivePreview() {
            this.isPreviewing = false;
            this.tabsVisible = true;
        },

        publishActionCompleted({ published, isWorkingCopy, response }) {
            this.saving = false;
            this.$refs.container.saved();
            if (published !== undefined) this.published = published;
            this.isWorkingCopy = isWorkingCopy;
            this.confirmingPublish = false;
            this.permalink = response.data.data.permalink
            this.$nextTick(() => this.$emit('saved', response));
        },

        setFieldValue(handle, value) {
            if (this.hasOrigin) this.desyncField(handle);

            this.$refs.container.setFieldValue(handle, value);
        },

        syncField(handle) {
            if (! confirm(__('Are you sure? This field\'s value will be replaced by the value in the original entry.')))
                return;

            this.localizedFields = this.localizedFields.filter(field => field !== handle);
            this.$refs.container.setFieldValue(handle, this.originValues[handle]);

            // Update the meta for this field. For instance, a relationship field would have its data preloaded into it.
            // If you sync the field, the preloaded data would be outdated and an ID would show instead of the titles.
            this.meta[handle] = this.originMeta[handle];
        },

        desyncField(handle) {
            if (!this.localizedFields.includes(handle))
                this.localizedFields.push(handle);

            this.$refs.container.dirty();
        },

        afterActionSuccessfullyCompleted(response) {
            if (response.data) {
                this.title = response.data.title;
                this.permalink = response.data.permalink;
                this.values = this.resetValuesFromResponse(response.data.values);
            }
        },

    },

    mounted() {
        this.saveKeyBinding = this.$keys.bindGlobal(['mod+return'], e => {
            e.preventDefault();
            if (this.confirmingPublish) return;
            this.canPublish ? this.confirmPublish() : this.save();
        });

        this.quickSaveKeyBinding = this.$keys.bindGlobal(['mod+s'], e => {
            e.preventDefault();
            if (this.confirmingPublish) return;
            this.quickSave = true;
            this.canPublish ? this.confirmPublish() : this.save();
        });

        this.$store.commit(`publish/${this.publishContainer}/setPreloadedAssets`, this.preloadedAssets);
    },

    created() {
        window.history.replaceState({}, document.title, document.location.href.replace('created=true', ''));
    },

    destroyed() {
        this.saveKeyBinding.destroy();
        this.quickSaveKeyBinding.destroy();
    }

}
</script>
