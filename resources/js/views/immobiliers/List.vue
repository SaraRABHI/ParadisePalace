<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button class="filter-item" type="primary" icon="el-icon-plus" @click="handleCreateForm">
        {{ $t('table.add') }}
      </el-button>
    </div>
     <el-table v-loading="loading" :data="list" border fit highlight-current-row>
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Title" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.title }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Owner Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.nameOwner }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Owner Email" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.emailOwner }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Adresse">
        <template slot-scope="scope">
          <span>{{ scope.row.adresse }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Description">
        <template slot-scope="scope">
          <span>{{ scope.row.description }}</span>
        </template>
      </el-table-column>

      <!-- <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
            Delete
          </el-button>
        </template>
      </el-table-column> -->

      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEditForm(scope.row.id, scope.row.title);">
            Edit
          </el-button>
          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.title);">
            Delete
          </el-button>
        </template>
      </el-table-column>

    </el-table>

    <el-dialog :title="'Create new Immobilier'" :visible.sync="immobilierFormVisible">
      <div class="form-container">
        <el-form ref="immobilierForm" :model="currentImmobilier" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item label="Title" prop="title">
            <el-input v-model="currentImmobilier.title" />
          </el-form-item>
          <el-form-item label="Name Owner" prop="nameOwner">
            <el-input v-model="currentImmobilier.nameOwner" />
          </el-form-item>
          <el-form-item label="Email Owner" prop="emailOwner">
            <el-input v-model="currentImmobilier.emailOwner" />
          </el-form-item>
          <el-form-item label="Adresse" prop="adresse">
            <el-input v-model="currentImmobilier.adresse" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentImmobilier.description" type="textarea" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="immobilierFormVisible = false">
            Cancel
          </el-button>
          <el-button type="primary" @click="handleSubmit()">
            Confirm
          </el-button>
        </div>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import Resource from '@/api/resource';
const immobilierResource = new Resource('immobiliers');

export default {
  name: 'ImmobilierList',
  data() {
    return {
      list: [],
      loading: true,
      immobilierFormVisible: false,
      currentImmobilier: {},
      formTitle: '',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
        this.loading = true;
      const { data } = await immobilierResource.list({});
      this.list = data;
      this.loading = false;
    },

    handleSubmit() {
        if (this.currentImmobilier.id !== undefined) {
        immobilierResource.update(this.currentImmobilier.id, this.currentImmobilier).then(response => {
          this.$message({
            type: 'success',
            message: 'Immobilier info has been updated successfully',
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.immobilierFormVisible = false;
        });
      } else {
        immobilierResource
          .store(this.currentImmobilier)
          .then(response => {
            this.$message({
              message: 'New immobilier ' + this.currentImmobilier.title + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentImmobilier = {
              title: '',
              nameOwner: '',
              emailOwner: '',
              adresse: '',
              description: '',
            };
            this.immobilierFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });}
     },

    handleCreateForm() {
      this.immobilierFormVisible = true;
      this.currentImmobilier = {
        title: '',
        nameOwner: '',
        emailOwner: '',
        adresse: '',
        description: '',
      };
    },

    handleDelete(id, title) {
      this.$confirm('This will permanently delete category ' + title + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        immobilierResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: 'Delete completed',
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },
    
    handleEditForm(id) {
      this.formTitle = 'Edit immobilier';
      this.currentImmobilier = this.list.find(immobilier => immobilier.id === id);
      this.immobilierFormVisible = true;
    },

  },
};
</script>