<template>
    <div>
        <ul style="margin-bottom:8px;margin-top:8px">
            <li v-for="item in cat.children_recursive"
                style="margin-right:15px;text-align: right;font-size:14px;margin-bottom: 10px;">
                <i class="fas fa-chevron-left" style="margin-left: 3px;font-size: 12px;color: #afafaf;"></i>
                <input v-on:keydown.enter.prevent="redirectFilter($event,item.id)" :value="item.name"
                       style="border: unset;background-color: #f4f6f9;">
                <categories-list :cat="item"></categories-list>
            </li>
        </ul>
    </div>

</template>

<script>

    export default {
        props: ['cat'],
        methods: {
            redirectFilter(e, id) {
                if (e.target.value == '') {
                    this.deleteCategory(id);
                } else {
                    let formData = new FormData();
                    formData.append('name', e.target.value);
                    formData.append('id', id);

                    axios.post('/admin/category/edit', formData)
                        .then(function (response) {
                            location.reload();
                        });
                }
            },
            deleteCategory(id) {
                let obj = this;
                swal.fire({
                    text: "آیا از پاک کردن اطمینان دارید ؟",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله',
                    cancelButtonText: 'لغو',
                }).then((result) => {
                    if (result.value) {
                        axios.get(`/admin/category/delete/${id}`)
                            .then((res) => {
                                if (res.data === "cant") {
                                    swal.fire(
                                        {
                                            text: "این دسته دارای وابستگی می باشد و نمیتوان آن را حذف کرد",
                                            type: "warning",
                                            confirmButtonText: 'باشه',
                                        }
                                    );
                                    setTimeout(function () {
                                        location.reload();
                                    }, 3000);
                                } else {
                                    location.reload();
                                }
                            }).catch(() => {
                            swal.fire(
                                {
                                    text: "درخواست شما انجام نشد !",
                                    type: "error",
                                    confirmButtonText: 'باشه',
                                }
                            )
                        });
                    }
                });
            },
        },
        mounted() {

        },
        updated: function () {

        }
    }
</script>

<style scoped>
    ul {
        list-style: none;
    }
</style>