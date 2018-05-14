<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/1/2018
 * Time: 12:23 AM
 */
?>

<div class="form-group form-inline">
    <label class="col-form-label mr-2">{{ __('common.save_and_then') }}</label>
    @component('admin.shared.input.select-component')
        @slot('name') saveAfterAction @endslot
        @slot('class') form-control-sm @endslot
        @slot('option')
            @if (is_edit())
                <option value="{{ \App\Enumeration\SaveAfterActionEnum::CONTINUE_EDIT }}"
                        {{ (\App\Service\Admin\Util\SaveAfterActionUtil::getSaveAfterAction() === \App\Enumeration\SaveAfterActionEnum::CONTINUE_EDIT ? 'selected' : '') }}
                >{{ __('common.continue_edit') }}</option>

                @if (!empty(URL::previous()))
                    <option value="{{ \App\Enumeration\SaveAfterActionEnum::BACK_TO_PREVIOUS }}"
                            {{ (\App\Service\Admin\Util\SaveAfterActionUtil::getSaveAfterAction() === \App\Enumeration\SaveAfterActionEnum::BACK_TO_PREVIOUS ? 'selected' : '') }}
                    >{{ __('common.back_to_previous') }}</option>
                @endif

                @if (empty($noCreate))
                    <option value="{{ \App\Enumeration\SaveAfterActionEnum::INSERT_NEW_RECORD }}"
                            {{ (\App\Service\Admin\Util\SaveAfterActionUtil::getSaveAfterAction() === \App\Enumeration\SaveAfterActionEnum::INSERT_NEW_RECORD ? 'selected' : '') }}
                    >{{ __('common.insert_new_record') }}</option>
                @endif
            @else
                <option value="{{ \App\Enumeration\SaveAfterActionEnum::INSERT_NEW_RECORD }}"
                        {{ (\App\Service\Admin\Util\SaveAfterActionUtil::getSaveAfterAction() === \App\Enumeration\SaveAfterActionEnum::INSERT_NEW_RECORD ? 'selected' : '') }}
                >{{ __('common.insert_new_record') }}</option>
                @if (!empty(URL::previous()))
                    <option value="{{ \App\Enumeration\SaveAfterActionEnum::BACK_TO_PREVIOUS }}"
                            {{ (\App\Service\Admin\Util\SaveAfterActionUtil::getSaveAfterAction() === \App\Enumeration\SaveAfterActionEnum::BACK_TO_PREVIOUS ? 'selected' : '') }}
                    >{{ __('common.back_to_previous') }}</option>
                @endif

                @if (empty($noCreate))
                    <option value="{{ \App\Enumeration\SaveAfterActionEnum::CONTINUE_EDIT }}"
                            {{ (\App\Service\Admin\Util\SaveAfterActionUtil::getSaveAfterAction() === \App\Enumeration\SaveAfterActionEnum::CONTINUE_EDIT ? 'selected' : '') }}
                    >{{ __('common.continue_edit') }}</option>
                @endif
            @endif
        @endslot
    @endcomponent

    @if (!empty(URL::previous()))
        <input type="hidden" name="previousUrl" value="{{ URL::previous() }}">
    @endif
</div>
