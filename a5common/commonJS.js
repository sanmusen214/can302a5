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