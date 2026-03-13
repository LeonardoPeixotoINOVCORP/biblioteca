<script setup>
import * as XLSX from 'xlsx'

const props = defineProps({
  dados: Array,        // os dados da tabela
  colunas: Array,      // ex: ['Nome', 'Email', 'Data']
  nomeArquivo: {
    type: String,
    default: 'exportacao'
  }
})

function exportarExcel() {
  const ws = XLSX.utils.json_to_sheet(props.dados)
  const wb = XLSX.utils.book_new()
  XLSX.utils.book_append_sheet(wb, ws, 'Dados')
  XLSX.writeFile(wb, `${props.nomeArquivo}.xlsx`)
}
</script>

<template>
  <button @click="exportarExcel">
    Exportar Excel
  </button>
</template>