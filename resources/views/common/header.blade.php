<div class="mdui-appbar mdui-appbar-fixed">
    <div class="mdui-toolbar mdui-color-teal mdui-text-color-white-text ">
        <span  class="mdui-btn mdui-btn-icon" mdui-drawer="{target: '#main-drawer', swipe: true}"><i class="mdui-icon material-icons">menu</i></span>
        <a href="https://vip.o11o.cc" class="mdui-typo-headline">嗖嗖</a>
        <div class="mdui-toolbar-spacer"></div>
        @if(Session::has('user'))
            <a href="javascript:;" class="mdui-btn " mdui-dialog="{target: '#dialog-login'}" style=" display: block;max-width: 140px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;"><strong style="font-size: large">{{Session('user')}}</strong></a>

        @else
            <a href="javascript:;" class="mdui-btn " mdui-dialog="{target: '#dialog-login'}"><strong style="font-size: large">登录</strong></a>

        @endif
    </div>
</div>


<div class="mdui-dialog" id="dialog-login">
    <div class="mdui-dialog-title">登录</div>
    <div class="mdui-dialog-content">
        <div class="mdui-textfield mdui-textfield-floating-label">
            <label class="mdui-textfield-label">用户名</label>
            <input class="mdui-textfield-input" type="text" id="username" name="username">
        </div>
        <div class="mdui-textfield mdui-textfield-floating-label">
            <label class="mdui-textfield-label">密码</label>
            <input class="mdui-textfield-input" type="password" id="password" name="password">
        </div>
        <p><button class="mdui-btn mdui-ripple mdui-text-color-pink" id="register">还没有账号？立即注册</button></p>
    </div>
    <div class="mdui-divider"></div>
    <div class="mdui-dialog-actions">
        <button class="mdui-btn mdui-ripple" id="loginCancel" mdui-dialog-close>取消</button>
        <button class="mdui-btn mdui-ripple" id="doLogin">登录</button>
    </div>
</div>

<div class="mdui-dialog" id="dialog-register">
    <div class="mdui-dialog-title">注册</div>
    <div class="mdui-dialog-content">
        <div class="mdui-textfield mdui-textfield-floating-label">
            <label class="mdui-textfield-label">用户名</label>
            <input class="mdui-textfield-input" type="text" id="rUsername" name="username">
        </div>
        <div class="mdui-textfield mdui-textfield-floating-label">
            <label class="mdui-textfield-label">密码</label>
            <input class="mdui-textfield-input" type="password" id="rPassword" name="password">
        </div>
        <div class="mdui-textfield mdui-textfield-floating-label">

                <label class="mdui-textfield-label">验证码</label>
                <input class="mdui-textfield-input" type="text" id="code" name="code" style="width: 30%;">
                <img src="{{ URL('captcha') }}" id="img" alt="验证码" title="刷新图片"  height="40" id="img" border="0" style="margin-top: -34px;margin-left: 32%" onclick="javascript:this.src='captcha'+'?'+Math.random()">

        </div>
        <p><button class="mdui-btn mdui-ripple mdui-text-color-pink" id="login">已有账号？立即登录</button></p>
    </div>
    <div class="mdui-divider"></div>
    <div class="mdui-dialog-actions">
        <button class="mdui-btn mdui-ripple" id="registerCancel" mdui-dialog-close>取消</button>
        <button class="mdui-btn mdui-ripple" id="doRegister">注册</button>
    </div>
</div>

<script>
    var isLogin="{{Session('user')}}";
</script>

