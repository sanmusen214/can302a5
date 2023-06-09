// 可重复使用的js

window.addEventListener("load",function(){
    const searchbox=this.document.querySelector("#listsearchbox");
    if(searchbox){
        searchbox.addEventListener("keydown",entertosearch)
    }
    displayMessage();
})

function clickSomething(message=""){
    // 点击测试
    window.alert("你点击了这个东西");
}

// 获取侧边栏对象
const siderbar=new mdui.Drawer("#siderbar")
function toggleSiderbar(){
    // 展开/关闭侧边栏
    siderbar.toggle()
}

// 找到勾选了列表里的哪些行
function findWhichAreSelected(){
    console.log("列表哪些行被勾了")
    const selectablelist=document.querySelector(".mdui-table-selectable")
    const reslist=[]
    for(let eachrow of selectablelist.querySelector("tbody").children){
        if(eachrow.className==="mdui-table-row-selected"){
            let rowelements=[]
            for(let eachcol of eachrow.children){
                rowelements.push(eachcol.innerText)
            }
            reslist.push(rowelements)
        }
    }
    console.log(reslist)
    return reslist
}

// 参数跳转,url添加搜索关键词
function entertosearch(e){
    if(e.code==="Enter"){
        if(e.target.value===""){
            location.href=location.href.split("?")[0]
        }else{
            location.href=location.href.split("?")[0]+"?searchword="+e.target.value
        }

    }
}

// 点击搜索icon，url添加搜索关键词
function clicktosearch(){
    const searchbox=this.document.querySelector("#listsearchbox");
    if(searchbox.value){
        location.href=location.href.split("?")[0]+"?searchword="+searchbox.value
    }
}

// 点击跳转现在url,清除url参数
function clicktoclear(){
    location.href=location.href.split("?")[0]
}

/**
 * @param obj this 对象
 * @param remindword str 不符合pattern的话提醒的字符串
 */
function checkit(obj, remindword) {
    // console.log(obj.validity);
    const it = obj.validity;
    if (it.valueMissing === true) {
        obj.setCustomValidity("It is required");
    } else {
        if (it.patternMismatch === true) {
            obj.setCustomValidity(remindword);
        }else{
            obj.setCustomValidity('');
        }
    }
}

/**
 * 发起ajax请求，查找并返回数据表中某列的值的列表
 * 
 * @param tablename 数据表名
 * @param indexname 想要获取的列的列名
 * @param callback 获取成功后的回调函数
 */
function getValidIndex(tablename,indexname,callback){
    let url=`a5common/api.php?tablename=${tablename}&indexname=${indexname}`
    $.get(url,function(result){
        callback(result)
    }, 'json');
}

// 禁用点击,表单提交没用
function cannotclick(e){
    e.preventDefault();
}

// 阻止并提醒一次点击
function checksubmit(e){
    console.log(e)
    return false;
}

/**
 * 设定某一个input里的字符串必须在某个数据表的某列里存在
 * 该input必须有required和pattern
 * @param elementid 那个input的id，不带#号
 * @param tablename 数据表名
 * @param indexname 数据列名
 * @param mentionword 自定义提示词
 * 
 */
function itMustExist(elementid,tablename,indexname,mentionword="Do not exist"){
    getValidIndex(tablename,indexname,(res)=>{
        let namelist=res.data;
        document.querySelector(`#${elementid}`).addEventListener("input",(e)=>{
            if(!namelist.includes(e.target.value)){
                document.querySelector(`#${elementid}`).setCustomValidity(mentionword)
            }else{
                document.querySelector(`#${elementid}`).setCustomValidity("")
            }
        })
    })
}

/**
 * 设定某一个input里的字符串必须不在某个数据表的某列里
 * 该input必须有required和pattern
 * @param elementid 那个input的id，不带#号
 * @param tablename 数据表名
 * @param indexname 数据列名
 * @param exceptval 如果input的值为该值，则不进行该判断
 * @param mentionword 自定义提示词
 */
 function itMustNotExist(elementid,tablename,indexname,exceptval="|",mentionword="It is duplicated"){
    getValidIndex(tablename,indexname,(res)=>{
        let namelist=res.data;
        document.querySelector(`#${elementid}`).addEventListener("input",(e)=>{
            // 如果input的值为exceptval，则不进行该判断
            // 例如，用户名为aa的用户最终还是决定用aa这个名字，此时不应该判断aa是不是不在名字那一列里面。
            if(e.target.value===exceptval){
                document.querySelector(`#${elementid}`).setCustomValidity("")
            }else{
                if(namelist.includes(e.target.value)){
                    document.querySelector(`#${elementid}`).setCustomValidity(mentionword)
                }else{
                    document.querySelector(`#${elementid}`).setCustomValidity("")
                }
            }
        })
    })
}

// 存储消息，用于页面间消息提示
function saveMessage(message){
    localStorage.setItem("mymsg",message)
}

// 获取url参数
function getQueryVariable(variable){
    let query = window.location.search.substring(1);
    let vars = query.split("&");
    for (let i=0;i<vars.length;i++) {
            let pair = vars[i].split("=");
            if(pair[0] == variable){return pair[1];}
    }
    return("");
}

// 消费消息，用于页面间消息提示
// 一旦调用，清除localStorage里的消息
function displayMessage(){
    mymsg=localStorage.getItem("mymsg")
    if(!mymsg){
        // 如果localStorage里没有
        // 从网页url查找
        mymsg=getQueryVariable("message")
    }
    if(mymsg){
        mdui.snackbar({
            message: mymsg,
            position: 'right-bottom'
          });
    }
    localStorage.removeItem("mymsg")
}