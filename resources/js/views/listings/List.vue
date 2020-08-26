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

    <el-dialog :title="'Create new Listing'" :visible.sync="listingFormVisible">
      <div class="form-container">
        <el-form ref="listingForm" :model="currentListing" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item label="Title" prop="title">
            <el-input v-model="currentListing.title" />
          </el-form-item>
          <el-form-item label="Name Owner" prop="nameOwner">
            <el-input v-model="currentListing.nameOwner" />
          </el-form-item>
          <el-form-item label="Email Owner" prop="emailOwner">
            <el-input v-model="currentListing.emailOwner" />
          </el-form-item>
          <el-form-item label="Description" prop="description">
            <el-input v-model="currentListing.description" type="textarea" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="listingFormVisible = false">
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
const listingResource = new Resource('listings');

export default {
  name: 'ListingList',
  data() {
    return {
      list: [],
      loading: true,
      listingFormVisible: false,
      currentListing: {},
      formTitle: '',
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
        this.loading = true;
      const { data } = await listingResource.list({});
      this.list = data;
      this.loading = false;
    },

    handleSubmit() {
        if (this.currentListing.id !== undefined) {
        listingResource.update(this.currentListing.id, this.currentListing).then(response => {
          this.$message({
            type: 'success',
            message: 'Listing info has been updated successfully',
            duration: 5 * 1000,
          });
          this.getList();
        }).catch(error => {
          console.log(error);
        }).finally(() => {
          this.listingFormVisible = false;
        });
      } else {
        listingResource
          .store(this.currentListing)
          .then(response => {
            this.$message({
              message: 'New listing ' + this.currentListing.title + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.currentListing = {
              title: '',
              nameOwner: '',
              emailOwner: '',
              description: '',
            };
            this.listingFormVisible = false;
            this.getList();
          })
          .catch(error => {
            console.log(error);
          });}
     },

    handleCreateForm() {
      this.listingFormVisible = true;
      this.currentListing = {
        title: '',
        nameOwner: '',
        emailOwner: '',
        description: '',
      };
    },

    handleDelete(id, title) {
      this.$confirm('This will permanently delete category ' + title + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        listingResource.destroy(id).then(response => {
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
      this.formTitle = 'Edit listing';
      this.currentListing = this.list.find(listing => listing.id === id);
      this.listingFormVisible = true;
    },

  },
};
</script>