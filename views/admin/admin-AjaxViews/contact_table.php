<?php if($allMessages != null): ?>
        <div class="mb-3">
            <h3>Contact Messages</h3>
        </div>
        <table class="table table-dark table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Email</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allMessages as $message): ?>
                    <tr>
                        <td><?php echo $message['id'] ?></td>
                        <td><?php echo $message['email'] ?></td>
                        <td><?php echo $message['subject'] ?></td>
                        <td><?php echo $message['status'] ?></td>
                        <td>
                            <a href="/admin/admin-viewMessage?id=<?php echo $message['id']?>">View</a> | 
                            <a href="/admin/admin-deleteMessage?id=<?php echo $message['id']?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation">  
            <ul class="pagination" id="pagination">
                <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=1">First</a></li>
                <?php if(isset($contactPageNum) && $contactPageNum > 1): ?>
                    <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=<?php echo $contactPageNum-1?>">Previous</a></li>
                <?php else:?>
                    <li class="page-item"><a class="page-link" id="page-link">Previous</a></li>
                <?php endif; ?>
                <?php for($i=2; $i<$totalContactPage; $i++): ?>
                    <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=<?php echo $i?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
                <?php if(isset($contactPageNum) && $contactPageNum < $totalContactPage): ?>                                                                                                                         
                    <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=<?php echo $contactPageNum+1?>">Next</a></li>
                <?php else:?>
                    <li class="page-item"><a class="page-link" id="page-link">Next</a></li>
                <?php endif; ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=<?php echo $totalContactPage ?>">Last</a></li>
            </ul>
        </nav>
        
<?php endif; ?>
