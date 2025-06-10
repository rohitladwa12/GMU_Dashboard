#include<stdio.h>
int temp[10], k=0;

void sort (int a[10][10], int id[10], int n) {
    int i, j;
    for (i = 0; i < n; i++) {
        for (j = 0; j < n; j++) {
            if (id[j] == 0) {
                id[j] = -1;
                id[i] = id[j];
                temp[k++] = j;
                for (int z = 0; z < n; z++) {
                    if (a[j][z] == 1 && id[z] != -1) {
                        id[z]--;
                    }
                    i = -1;
                    break;
                }
            }
        }
    }
}

int main() {
    int n, i, j;
    int a[10][10], id[10];

    printf("Enter the number of vertices: ");
    scanf("%d", &n);

    printf("Enter the adjacency matrix:\n");
    for (i = 0; i < n; i++) {
        id[i] = 0;
        for (j = 0; j < n; j++) {
            scanf("%d", &a[i][j]);
            if (a[i][j] == 1) {
                id[j]++;
            }
        }
    }

    sort(a, id, n);

    printf("Topological Sort: ");
    for (i = 0; i < k; i++) {
        printf("%d ", temp[i]);
    }
    printf("\n");

    return 0;
}