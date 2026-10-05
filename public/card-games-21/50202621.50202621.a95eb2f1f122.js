"use strict";(self.webpackChunkhost_b2c_web_v3=self.webpackChunkhost_b2c_web_v3||[]).push([[0x2fe07fd],{0x9fab49(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onResult:e,resultReturns:r,onDone:o,rethrowIfPossible:s}){return this.callTapsSeries({onError:(e,r)=>t(r),onResult:(t,r,o)=>`if(${r} !== undefined) {
${e(r)};
} else {
${o()}}
`,resultReturns:r,onDone:o,rethrowIfPossible:s})}},i=()=>{throw Error("tapAsync is not supported on a SyncBailHook")},a=()=>{throw Error("tapPromise is not supported on a SyncBailHook")},c=function(t){return n.setup(this,t),n.create(t)};function l(t=[],e){let r=new o(t,e);return r.constructor=l,r.tapAsync=i,r.tapPromise=a,r.compile=c,r}l.prototype=null,t.exports=l},0xd2f763(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onDone:e}){return this.callTapsSeries({onError:(e,r,o,s)=>t(r)+s(!0),onDone:e})}},i=function(t){return n.setup(this,t),n.create(t)};function a(t=[],e){let r=new o(t,e);return r.constructor=a,r.compile=i,r._call=void 0,r.call=void 0,r}a.prototype=null,t.exports=a},0x1145c3e(t,e,r){let o=r(0x493db1c),s=(t,e)=>e;class n{constructor(t,e){this._map=new Map,this.name=e,this._factory=t,this._interceptors=[]}get(t){return this._map.get(t)}for(t){let e=this.get(t);if(void 0!==e)return e;let r=this._factory(t),o=this._interceptors;for(let e=0;e<o.length;e++)r=o[e].factory(t,r);return this._map.set(t,r),r}intercept(t){this._interceptors.push(Object.assign({factory:s},t))}}n.prototype.tap=o.deprecate(function(t,e,r){return this.for(t).tap(e,r)},"HookMap#tap(key,…) is deprecated. Use HookMap#for(key).tap(…) instead."),n.prototype.tapAsync=o.deprecate(function(t,e,r){return this.for(t).tapAsync(e,r)},"HookMap#tapAsync(key,…) is deprecated. Use HookMap#for(key).tapAsync(…) instead."),n.prototype.tapPromise=o.deprecate(function(t,e,r){return this.for(t).tapPromise(e,r)},"HookMap#tapPromise(key,…) is deprecated. Use HookMap#for(key).tapPromise(…) instead."),t.exports=n},0x187906d(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onDone:e}){return this.callTapsParallel({onError:(e,r,o,s)=>t(r)+s(!0),onDone:e})}},i=function(t){return n.setup(this,t),n.create(t)};function a(t=[],e){let r=new o(t,e);return r.constructor=a,r.compile=i,r._call=void 0,r.call=void 0,r}a.prototype=null,t.exports=a},0x19e09b5(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onDone:e,rethrowIfPossible:r}){return this.callTapsSeries({onError:(e,r)=>t(r),onDone:e,rethrowIfPossible:r})}},i=()=>{throw Error("tapAsync is not supported on a SyncHook")},a=()=>{throw Error("tapPromise is not supported on a SyncHook")},c=function(t){return n.setup(this,t),n.create(t)};function l(t=[],e){let r=new o(t,e);return r.constructor=l,r.tapAsync=i,r.tapPromise=a,r.compile=c,r}l.prototype=null,t.exports=l},0x2e9ccef(t,e,r){r(0x488163a);class o{constructor(t,e){this.hooks=t,this.name=e}tap(t,e){for(let r of this.hooks)r.tap(t,e)}tapAsync(t,e){for(let r of this.hooks)r.tapAsync(t,e)}tapPromise(t,e){for(let r of this.hooks)r.tapPromise(t,e)}isUsed(){for(let t of this.hooks)if(t.isUsed())return!0;return!1}intercept(t){for(let e of this.hooks)e.intercept(t)}withOptions(t){return new o(this.hooks.map(e=>e.withOptions(t)),this.name)}}t.exports=o},0x2fe07fd(t,e,r){e.__esModule=!0,e.SyncHook=r(0x19e09b5),e.SyncBailHook=r(0x9fab49),e.SyncWaterfallHook=r(0x4c52839),e.SyncLoopHook=r(0x4baf6ab),e.AsyncParallelHook=r(0x187906d),e.AsyncParallelBailHook=r(0x5d05ee1),e.AsyncSeriesHook=r(0xd2f763),e.AsyncSeriesBailHook=r(0x30a465b),e.AsyncSeriesLoopHook=r(0x4fa0ac9),e.AsyncSeriesWaterfallHook=r(0x38e6f17),e.HookMap=r(0x1145c3e),e.MultiHook=r(0x2e9ccef)},0x30a465b(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onResult:e,resultReturns:r,onDone:o}){return this.callTapsSeries({onError:(e,r,o,s)=>t(r)+s(!0),onResult:(t,r,o)=>`if(${r} !== undefined) {
${e(r)}
} else {
${o()}}
`,resultReturns:r,onDone:o})}},i=function(t){return n.setup(this,t),n.create(t)};function a(t=[],e){let r=new o(t,e);return r.constructor=a,r.compile=i,r._call=void 0,r.call=void 0,r}a.prototype=null,t.exports=a},0x38e6f17(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onResult:e,onDone:r}){return this.callTapsSeries({onError:(e,r,o,s)=>t(r)+s(!0),onResult:(t,e,r)=>{let o="";return o+=`if(${e} !== undefined) {
`,o+=`${this._args[0]} = ${e};
`,o+=`}
`,o+=r()},onDone:()=>e(this._args[0])})}},i=function(t){return n.setup(this,t),n.create(t)};function a(t=[],e){if(t.length<1)throw Error("Waterfall hooks must have at least one argument");let r=new o(t,e);return r.constructor=a,r.compile=i,r._call=void 0,r.call=void 0,r}a.prototype=null,t.exports=a},0x3fac1c9(t){t.exports=class{constructor(t){this.config=t,this.options=void 0,this._args=void 0}create(t){let e;switch(this.init(t),this.options.type){case"sync":e=Function(this.args(),`"use strict";
`+this.header()+this.contentWithInterceptors({onError:t=>`throw ${t};
`,onResult:t=>`return ${t};
`,resultReturns:!0,onDone:()=>"",rethrowIfPossible:!0}));break;case"async":e=Function(this.args({after:"_callback"}),`"use strict";
`+this.header()+this.contentWithInterceptors({onError:t=>`_callback(${t});
`,onResult:t=>`_callback(null, ${t});
`,onDone:()=>`_callback();
`}));break;case"promise":let r=!1,o=this.contentWithInterceptors({onError:t=>(r=!0,`_error(${t});
`),onResult:t=>`_resolve(${t});
`,onDone:()=>`_resolve();
`}),s="";s+=`"use strict";
`,s+=this.header(),s+=`return new Promise((function(_resolve, _reject) {
`,r&&(s+=`var _sync = true;
`,s+=`function _error(_err) {
`,s+=`if(_sync)
`,s+=`_resolve(Promise.resolve().then((function() { throw _err; })));
`,s+=`else
`,s+=`_reject(_err);
`,s+=`};
`),s+=o,r&&(s+=`_sync = false;
`),s+=`}));
`,e=Function(this.args(),s)}return this.deinit(),e}setup(t,e){t._x=e.taps.map(t=>t.fn)}init(t){this.options=t,this._args=t.args.slice()}deinit(){this.options=void 0,this._args=void 0}contentWithInterceptors(t){if(!(this.options.interceptors.length>0))return this.content(t);{let e=t.onError,r=t.onResult,o=t.onDone,s="";for(let t=0;t<this.options.interceptors.length;t++){let e=this.options.interceptors[t];e.call&&(s+=`${this.getInterceptor(t)}.call(${this.args({before:e.context?"_context":void 0})});
`)}return s+this.content(Object.assign(t,{onError:e&&(t=>{let r="";for(let e=0;e<this.options.interceptors.length;e++)this.options.interceptors[e].error&&(r+=`${this.getInterceptor(e)}.error(${t});
`);return r+e(t)}),onResult:r&&(t=>{let e="";for(let r=0;r<this.options.interceptors.length;r++)this.options.interceptors[r].result&&(e+=`${this.getInterceptor(r)}.result(${t});
`);return e+r(t)}),onDone:o&&(()=>{let t="";for(let e=0;e<this.options.interceptors.length;e++)this.options.interceptors[e].done&&(t+=`${this.getInterceptor(e)}.done();
`);return t+o()})}))}}header(){let t="";return this.needContext()?t+=`var _context = {};
`:t+=`var _context;
`,t+=`var _x = this._x;
`,this.options.interceptors.length>0&&(t+=`var _taps = this.taps;
var _interceptors = this.interceptors;
`),t}needContext(){for(let t of this.options.taps)if(t.context)return!0;return!1}callTap(t,{onError:e,onResult:r,onDone:o,rethrowIfPossible:s}){let n="",i=!1;for(let e=0;e<this.options.interceptors.length;e++){let r=this.options.interceptors[e];r.tap&&(i||(n+=`var _tap${t} = ${this.getTap(t)};
`,i=!0),n+=`${this.getInterceptor(e)}.tap(${r.context?"_context, ":""}_tap${t});
`)}n+=`var _fn${t} = ${this.getTapFn(t)};
`;let a=this.options.taps[t];switch(a.type){case"sync":s||(n+=`var _hasError${t} = false;
`,n+=`try {
`),r?n+=`var _result${t} = _fn${t}(${this.args({before:a.context?"_context":void 0})});
`:n+=`_fn${t}(${this.args({before:a.context?"_context":void 0})});
`,s||(n+=`} catch(_err) {
`,n+=`_hasError${t} = true;
`,n+=e("_err"),n+=`}
`,n+=`if(!_hasError${t}) {
`),r&&(n+=r(`_result${t}`)),o&&(n+=o()),s||(n+=`}
`);break;case"async":let c="";r?c+=`(function(_err${t}, _result${t}) {
`:c+=`(function(_err${t}) {
`,c+=`if(_err${t}) {
`,c+=e(`_err${t}`),c+=`} else {
`,r&&(c+=r(`_result${t}`)),o&&(c+=o()),c+=`}
`,c+="})",n+=`_fn${t}(${this.args({before:a.context?"_context":void 0,after:c})});
`;break;case"promise":n+=`var _hasResult${t} = false;
`,n+=`var _promise${t} = _fn${t}(${this.args({before:a.context?"_context":void 0})});
`,n+=`if (!_promise${t} || !_promise${t}.then)
`,n+=`  throw new Error('Tap function (tapPromise) did not return promise (returned ' + _promise${t} + ')');
`,n+=`_promise${t}.then((function(_result${t}) {
`,n+=`_hasResult${t} = true;
`,r&&(n+=r(`_result${t}`)),o&&(n+=o()),n+=`}), function(_err${t}) {
`,n+=`if(_hasResult${t}) throw _err${t};
`,n+=e(`_err${t}`),n+=`});
`}return n}callTapsSeries({onError:t,onResult:e,resultReturns:r,onDone:o,doneReturns:s,rethrowIfPossible:n}){if(0===this.options.taps.length)return o();let i=this.options.taps.findIndex(t=>"sync"!==t.type),a=r||s,c="",l=o,p=0;for(let r=this.options.taps.length-1;r>=0;r--){let s=r;l!==o&&("sync"!==this.options.taps[s].type||p++>20)&&(p=0,c+=`function _next${s}() {
`,c+=l(),c+=`}
`,l=()=>`${a?"return ":""}_next${s}();
`);let h=l,u=t=>t?"":o(),f=this.callTap(s,{onError:e=>t(s,e,h,u),onResult:e&&(t=>e(s,t,h,u)),onDone:!e&&h,rethrowIfPossible:n&&(i<0||s<i)});l=()=>f}return c+l()}callTapsLooping({onError:t,onDone:e,rethrowIfPossible:r}){if(0===this.options.taps.length)return e();let o=this.options.taps.every(t=>"sync"===t.type),s="";o||(s+=`var _looper = (function() {
`,s+=`var _loopAsync = false;
`),s+=`var _loop;
`,s+=`do {
`,s+=`_loop = false;
`;for(let t=0;t<this.options.interceptors.length;t++){let e=this.options.interceptors[t];e.loop&&(s+=`${this.getInterceptor(t)}.loop(${this.args({before:e.context?"_context":void 0})});
`)}return s+=this.callTapsSeries({onError:t,onResult:(t,e,r,s)=>{let n="";return n+=`if(${e} !== undefined) {
`,n+=`_loop = true;
`,o||(n+=`if(_loopAsync) _looper();
`),n+=s(!0),n+=`} else {
`,n+=r(),n+=`}
`},onDone:e&&(()=>{let t="";return t+=`if(!_loop) {
`,t+=e(),t+=`}
`}),rethrowIfPossible:r&&o}),s+=`} while(_loop);
`,o||(s+=`_loopAsync = true;
`,s+=`});
`,s+=`_looper();
`),s}callTapsParallel({onError:t,onResult:e,onDone:r,rethrowIfPossible:o,onTap:s=(t,e)=>e()}){if(this.options.taps.length<=1)return this.callTapsSeries({onError:t,onResult:e,onDone:r,rethrowIfPossible:o});let n="";n+=`do {
`,n+=`var _counter = ${this.options.taps.length};
`,r&&(n+=`var _done = (function() {
`,n+=r(),n+=`});
`);for(let i=0;i<this.options.taps.length;i++){let a=()=>r?`if(--_counter === 0) _done();
`:"--_counter;",c=t=>t||!r?`_counter = 0;
`:`_counter = 0;
_done();
`;n+=`if(_counter <= 0) break;
`,n+=s(i,()=>this.callTap(i,{onError:e=>{let r="";return r+=`if(_counter > 0) {
`,r+=t(i,e,a,c),r+=`}
`},onResult:e&&(t=>{let r="";return r+=`if(_counter > 0) {
`,r+=e(i,t,a,c),r+=`}
`}),onDone:!e&&(()=>a()),rethrowIfPossible:o}),a,c)}return n+`} while(false);
`}args({before:t,after:e}={}){let r=this._args;return(t&&(r=[t].concat(r)),e&&(r=r.concat(e)),0===r.length)?"":r.join(", ")}getTapFn(t){return`_x[${t}]`}getTap(t){return`_taps[${t}]`}getInterceptor(t){return`_interceptors[${t}]`}}},0x488163a(t,e,r){let o=r(0x493db1c).deprecate(()=>{},"Hook.context is deprecated and will be removed"),s=function(...t){return this.call=this._createCall("sync"),this.call(...t)},n=function(...t){return this.callAsync=this._createCall("async"),this.callAsync(...t)},i=function(...t){return this.promise=this._createCall("promise"),this.promise(...t)};class a{constructor(t=[],e){this._args=t,this.name=e,this.taps=[],this.interceptors=[],this._call=s,this.call=s,this._callAsync=n,this.callAsync=n,this._promise=i,this.promise=i,this._x=void 0,this.compile=this.compile,this.tap=this.tap,this.tapAsync=this.tapAsync,this.tapPromise=this.tapPromise}compile(t){throw Error("Abstract: should be overridden")}_createCall(t){return this.compile({taps:this.taps,interceptors:this.interceptors,args:this._args,type:t})}_tap(t,e,r){if("string"==typeof e)e={name:e.trim()};else if("object"!=typeof e||null===e)throw Error("Invalid tap options");if("string"!=typeof e.name||""===e.name)throw Error("Missing name for tap");void 0!==e.context&&o(),e=Object.assign({type:t,fn:r},e),e=this._runRegisterInterceptors(e),this._insert(e)}tap(t,e){this._tap("sync",t,e)}tapAsync(t,e){this._tap("async",t,e)}tapPromise(t,e){this._tap("promise",t,e)}_runRegisterInterceptors(t){for(let e of this.interceptors)if(e.register){let r=e.register(t);void 0!==r&&(t=r)}return t}withOptions(t){let e=e=>Object.assign({},t,"string"==typeof e?{name:e}:e);return{name:this.name,tap:(t,r)=>this.tap(e(t),r),tapAsync:(t,r)=>this.tapAsync(e(t),r),tapPromise:(t,r)=>this.tapPromise(e(t),r),intercept:t=>this.intercept(t),isUsed:()=>this.isUsed(),withOptions:t=>this.withOptions(e(t))}}isUsed(){return this.taps.length>0||this.interceptors.length>0}intercept(t){if(this._resetCompilation(),this.interceptors.push(Object.assign({},t)),t.register)for(let e=0;e<this.taps.length;e++)this.taps[e]=t.register(this.taps[e])}_resetCompilation(){this.call=this._call,this.callAsync=this._callAsync,this.promise=this._promise}_insert(t){let e;this._resetCompilation(),"string"==typeof t.before?e=new Set([t.before]):Array.isArray(t.before)&&(e=new Set(t.before));let r=0;"number"==typeof t.stage&&(r=t.stage);let o=this.taps.length;for(;o>0;){o--;let t=this.taps[o];this.taps[o+1]=t;let s=t.stage||0;if(e){if(e.has(t.name)){e.delete(t.name);continue}if(e.size>0)continue}if(!(s>r)){o++;break}}this.taps[o]=t}}Object.setPrototypeOf(a.prototype,null),t.exports=a},0x493db1c(t,e){e.deprecate=(t,e)=>{let r=!0;return function(){return r&&(console.warn("DeprecationWarning: "+e),r=!1),t.apply(this,arguments)}}},0x4baf6ab(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onDone:e,rethrowIfPossible:r}){return this.callTapsLooping({onError:(e,r)=>t(r),onDone:e,rethrowIfPossible:r})}},i=()=>{throw Error("tapAsync is not supported on a SyncLoopHook")},a=()=>{throw Error("tapPromise is not supported on a SyncLoopHook")},c=function(t){return n.setup(this,t),n.create(t)};function l(t=[],e){let r=new o(t,e);return r.constructor=l,r.tapAsync=i,r.tapPromise=a,r.compile=c,r}l.prototype=null,t.exports=l},0x4c52839(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onResult:e,resultReturns:r,rethrowIfPossible:o}){return this.callTapsSeries({onError:(e,r)=>t(r),onResult:(t,e,r)=>{let o="";return o+=`if(${e} !== undefined) {
`,o+=`${this._args[0]} = ${e};
`,o+=`}
`,o+=r()},onDone:()=>e(this._args[0]),doneReturns:r,rethrowIfPossible:o})}},i=()=>{throw Error("tapAsync is not supported on a SyncWaterfallHook")},a=()=>{throw Error("tapPromise is not supported on a SyncWaterfallHook")},c=function(t){return n.setup(this,t),n.create(t)};function l(t=[],e){if(t.length<1)throw Error("Waterfall hooks must have at least one argument");let r=new o(t,e);return r.constructor=l,r.tapAsync=i,r.tapPromise=a,r.compile=c,r}l.prototype=null,t.exports=l},0x4fa0ac9(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onDone:e}){return this.callTapsLooping({onError:(e,r,o,s)=>t(r)+s(!0),onDone:e})}},i=function(t){return n.setup(this,t),n.create(t)};function a(t=[],e){let r=new o(t,e);return r.constructor=a,r.compile=i,r._call=void 0,r.call=void 0,r}a.prototype=null,t.exports=a},0x5d05ee1(t,e,r){let o=r(0x488163a),s=r(0x3fac1c9),n=new class extends s{content({onError:t,onResult:e,onDone:r}){let o="";return o+=`var _results = new Array(${this.options.taps.length});
`,o+=`var _checkDone = function() {
`,o+=`for(var i = 0; i < _results.length; i++) {
`,o+=`var item = _results[i];
`,o+=`if(item === undefined) return false;
`,o+=`if(item.result !== undefined) {
`,o+=e("item.result"),o+=`return true;
`,o+=`}
`,o+=`if(item.error) {
`,o+=t("item.error"),o+=`return true;
`,o+=`}
`,o+=`}
`,o+=`return false;
`,o+=`}
`,o+=this.callTapsParallel({onError:(t,e,r,o)=>{let s="";return s+=`if(${t} < _results.length && ((_results.length = ${t+1}), (_results[${t}] = { error: ${e} }), _checkDone())) {
`,s+=o(!0),s+=`} else {
`,s+=r(),s+=`}
`},onResult:(t,e,r,o)=>{let s="";return s+=`if(${t} < _results.length && (${e} !== undefined && (_results.length = ${t+1}), (_results[${t}] = { result: ${e} }), _checkDone())) {
`,s+=o(!0),s+=`} else {
`,s+=r(),s+=`}
`},onTap:(t,e,r,o)=>{let s="";return t>0&&(s+=`if(${t} >= _results.length) {
`,s+=r(),s+=`} else {
`),s+=e(),t>0&&(s+=`}
`),s},onDone:r})}},i=function(t){return n.setup(this,t),n.create(t)};function a(t=[],e){let r=new o(t,e);return r.constructor=a,r.compile=i,r._call=void 0,r.call=void 0,r}a.prototype=null,t.exports=a}}]);