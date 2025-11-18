<div class="row">
    <div class="col-md-12">
        <educations-component
            :selected_educations="{{ json_encode($selectedEducations) }}"
            :educations="{{ json_encode($educations) }}"
            v-slot="{ items, educations, addRow, deleteRow, removeSelectedItem }"
        >
            <div class="mb-3">
                <div class="row g-2 mb-2" v-for="(item, index) in items">
                    <div class="col">
                        <select
                            :name="`educations[${index}1][id]`"
                            class="form-control form-select"
                            @change="removeSelectedItem"
                            data-placeholder="{{ trans('adminboard::lang.admineducation') }}"
                        >
                            <option value="0">{{ trans('adminboard::lang.admineducation') }}</option>
                            <option
                                v-for="(education, index) in educations"
                                :key="index"
                                :value="education.id"
                                :selected="education.id === item.id"
                            >
                                @{{ education.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col">
                        <input
                            type="text"
                            :name="`educations[${index}1][name_title]`"
                            v-model="item.name_title"
                            class="form-control"
                            placeholder="{{ trans('adminboard::lang.name') }}"
                        />
                    </div>
                    <div class="col-auto">
                        <x-kamruldashboard::button
                            @click="deleteRow(index)"
                            icon="ti ti-trash"
                            :icon-only="true"
                        />
                    </div>
                </div>
            </div>

            <a href="javascript:void(0)" role="button" @click="addRow">{{ trans('adminboard::lang.add_new') }}</a>
        </educations-component>
    </div>
</div>
