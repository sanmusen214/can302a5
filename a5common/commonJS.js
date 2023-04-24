// 可重复使用的js

function clickSomething(){
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
    return reslist
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

// 禁用点击
function cannotclick(e){
    e.preventDefault();
}

/**
 * 设定某一个input里的字符串必须在某个数据表的某列里存在
 * 该input必须有required和pattern
 * @param elementid 那个input的id，不带#号
 * @param tablename 数据表名
 * @param indexname 数据列名
 */
function itMustExist(elementid,tablename,indexname){
    getValidIndex(tablename,indexname,(res)=>{
        let namelist=res.data;
        document.querySelector(`#${elementid}`).addEventListener("input",(e)=>{
            if(!namelist.includes(e.target.value)){
                document.querySelector(`#${elementid}`).setCustomValidity("Do not exist")
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
 */
 function itMustNotExist(elementid,tablename,indexname,exceptval="|"){
    getValidIndex(tablename,indexname,(res)=>{
        let namelist=res.data;
        document.querySelector(`#${elementid}`).addEventListener("input",(e)=>{
            // 如果input的值为exceptval，则不进行该判断
            // 例如，用户名为aa的用户最终还是决定用aa这个名字，此时不应该判断aa是不是不在名字那一列里面。
            if(e.target.value===exceptval){
                document.querySelector(`#${elementid}`).setCustomValidity("")
            }else{
                if(namelist.includes(e.target.value)){
                    document.querySelector(`#${elementid}`).setCustomValidity("It is duplicated")
                }else{
                    document.querySelector(`#${elementid}`).setCustomValidity("")
                }
            }
        })
    })
}
