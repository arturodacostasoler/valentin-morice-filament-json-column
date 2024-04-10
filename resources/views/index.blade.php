<div>
    <div class="overflow-hidden shadow-sm master"
         @style([
            'border-radius: 0.5rem 0.5rem 0 0;' => $getMode() === '',
            'border-radius: 0;' => $getMode() === 'editor',
            'border-radius: 0.5rem;' => $getMode() === 'viewer',
         ])
         x-data="{
                       state: $wire.entangle('{{ $getStatePath() }}'),
                       get prettyJson() {
                           json = JSON.parse(this.state)
                           return window.prettyPrint(json)
                       },
                       display: 'viewer'
                    }"
    >
    @if($getMode() === '')
            <div class="container">
                <span class="font-medium text-sm py-3.5 px-4">
                    {{ $getLabel() ? $getLabel() : $getName() }}
                </span>
                <div class="flex">
                    <div class="text-sm px-5 py-3.5 control"
                         x-on:click="display = 'viewer'"
                         x-bind:class="display === 'viewer' ? 'active' : ''"
                    >
                        <div>Viewer</div>
                    </div>
                    <div class="text-sm px-5 py-3.5 overflow-hidden control"
                         x-on:click="display = 'editor'"
                         x-bind:class="display === 'editor' ? 'active' : ''"
                    >
                        <div>Editor</div>
                    </div>
                </div>
            </div>
            <div class="text-sm content"
                 x-show="display === 'viewer'"
            >
                <pre class="prettyjson" x-html="prettyJson"></span>
            </div>
            <div x-show="display === 'editor'"class="text-sm p-1">
                <div class="w-full"
                     x-init="$nextTick(() => {
                    const options = {
                        modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
                        history: true,
                        onChange: function(){
                        },
                        onChangeJSON: function(json){
                            state=JSON.stringify(json);
                        },
                        onChangeText: function(jsonString){
                            state=jsonString;
                        },
                        onValidationError: function (errors) {
                            errors.forEach((error) => {
                              switch (error.type) {
                                case 'validation': // schema validation error
                                  break;
                                case 'error':  // json parse error
                                    console.log(error.message);
                                  break;
                              }
                            })
                        }
                    };
                    if(typeof json_editor !== 'undefined'){
                        json_editor = new JSONEditor($refs.editor, options);
                        json_editor.set(JSON.parse(state));
                    } else {
                        let json_editor = new JSONEditor($refs.editor, options);
                        json_editor.set(JSON.parse(state));
                    }
                 })"
                     x-cloak
                     wire:ignore>
                    <div x-ref="editor" class="w-full ace_editor"
                         style="min-height: 30vh;height:300px"></div>
                </div>
            </div>
    @elseif($getMode() === 'editor')
            <div class="text-sm p-1">
                <div class="w-full"
                     x-init="$nextTick(() => {
                    const options = {
                        modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
                        history: true,
                        onChange: function(){
                        },
                        onChangeJSON: function(json){
                            state=JSON.stringify(json);
                        },
                        onChangeText: function(jsonString){
                            state=jsonString;
                        },
                        onValidationError: function (errors) {
                            errors.forEach((error) => {
                              switch (error.type) {
                                case 'validation': // schema validation error
                                  break;
                                case 'error':  // json parse error
                                    console.log(error.message);
                                  break;
                              }
                            })
                        }
                    };
                    if(typeof json_editor !== 'undefined'){
                        json_editor = new JSONEditor($refs.editor, options);
                        json_editor.set(JSON.parse(state));
                    } else {
                        let json_editor = new JSONEditor($refs.editor, options);
                        json_editor.set(JSON.parse(state));
                    }
                 })"
                     x-cloak
                     wire:ignore>
                    <div x-ref="editor" class="w-full ace_editor"
                         style="min-height: 30vh;height:300px"></div>
                </div>
            </div>
    @elseif($getMode() === 'viewer')
        <div class="text-sm content">
                <pre class="prettyjson" x-html="prettyJson"></span>
        </div>
    @endif
    </div>
    <style>
        .active {
            box-shadow:0 -3px 0 0 {{ $getAccent() }} inset;
        }
    </style>
</div>